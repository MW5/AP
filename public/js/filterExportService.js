$(document).ready(function() {
    
    $(".export_list_btn").click(function() {
        let currentModule = $(location).attr('href').substring(
                $(location).attr('href').lastIndexOf("/")+1,
                $(location).attr('href').lastIndexOf("Manager")
        )+"s";

        currentModule = currentModule.replace(
                /([a-z][A-Z])/g,
            function (g) {
            return g[0] + '_' + g[1].toLowerCase()
        });
        
        let pattern = $(".search").val();
        $.get(
            "/api/getFiltered",
            {
                module: currentModule,
                pattern: pattern
            },
            function(data){
                downloadCSV(Papa.unparse(data));
            }
        );
    });
    function downloadCSV(data) {  
        var blob = new Blob([data]);
        if (window.navigator.msSaveOrOpenBlob)  // IE hack
            window.navigator.msSaveBlob(blob, "export.csv");
        else
        {
            var a = window.document.createElement("a");
            a.href = window.URL.createObjectURL(blob, {type: "text/plain"});
            a.download = "filename.csv";
            document.body.appendChild(a);
            a.click();  // IE: "Access is denied";
            document.body.removeChild(a);
        }
    }     
});