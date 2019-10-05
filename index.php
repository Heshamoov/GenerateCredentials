<?php
 include('Header.php');
 ?>
 <head>
    <title>Generate Credentials</title>
</head>

<body>
    <div id="upperdiv" class="w3-container w3-mobile" style="padding-top: 10px; padding-bottom: 10px">
        <table id= "table1">
            <tr>
                <td>Grade</td>
                <td>Section</td>
            </tr>
            <tr>
                <td>
                    <select id="grades" onchange= "FillSections()" multiple="multiple"></select>   
                </td>
                <td>
                    <select id ="sections" multiple="multiple"></select>
                </td>
                <td>
                    <button style="padding: 15px 32px 32px 32px;
                        text-align: center ;font-size: 14px;"
                        class="w3-button w3-hover-blue-gray w3-custom w3-round-large"
                        id="search" onclick='search();' title="Generate Credentials">
                        <span class="fa fa-search"></span>
                    </button>
                </td>
            </tr>
        </table>
    </div>

    <!-- Fill Dropdowns -->
    <script type="text/javascript">
        var gradesArray = ["Your Data Base is Empty!."];
        var select = document.getElementById('grades');
        var httpGrades = new XMLHttpRequest();
        httpGrades.onreadystatechange = function () {
            if (this.readyState === 4) {
                var str = this.responseText;
                gradesArray = str.split("\t");
            }
        };
        httpGrades.open("GET", "mysql/grades.php", false);
        httpGrades.send();
            
        $('#grades').multiselect('destroy');
        delete gradesArray[gradesArray.length - 1];

        for (var i in gradesArray) {
                select.add(new Option(gradesArray[i]));
        };

        $(function () {
            $('#grades').multiselect({
                includeSelectAllOption: true
            });
        }); 
    </script>
    
   <script type="text/javascript">
    document.getElementById("grades").addEventListener("change", FillSections());

    function FillSections(){
        var sectionsArray = ["Your Data Base is Empty!."];
        var selected_grades = $("#grades option:selected");
        var select = document.getElementById('sections');

        while (select.length > 0)
                    select.remove(0);    

        var message = "";
        selected_grades.each(function () {
            if (message === "")
                message = "(courses.course_name = '" + $(this).text() + "' ";
            else
                message += " OR courses.course_name = '" + $(this).text() + "' ";
        });

        if (message !== "") {
            selected_grades = message + ")";
        } else
            selected_grades = "";

        var httpSections = new XMLHttpRequest();
        httpSections.onreadystatechange = function () {
            if (this.readyState === 4) {
                var str = this.responseText;
                sectionsArray = str.split("\t");
            }
        };
        httpSections.open("GET", "mysql/sections.php?grades=" + selected_grades, false);
        httpSections.send();
            
        $('#sections').multiselect('destroy');

        delete sectionsArray[sectionsArray.length - 1];

        for (var i in sectionsArray) {
                select.add(new Option(sectionsArray[i]));
        };

        $(function () {
            $('#sections').multiselect({
                includeSelectAllOption: true
            });
        }); 
    }
    </script>
</body>