<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OVL BoardPortal</title>
    <script src='/lib/webviewer.min.js'></script>
    <!--script src="../../../node_modules/dist/axios.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script-->
    <script src="{{ asset('js/manifest.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body style="margin:0">
    <div id='viewer' style='width: 100vw; height: 100vh;'></div>
    <script>

    var viewerElement = document.getElementById('viewer');
    //var doc = atob(document.getElementById("url").innerHTML);
    // var agenda = document.getElementById("agenda").innerHTML;
    
    
    var myWebViewer = new PDFTron.WebViewer({
        path: '/lib', // path to the PDFTron 'lib' folder on your server
        l: 'demo:Das_Sreenath@ongc.co.in:75de083d01991cd7d5c0cd8e67d0a3ed51a5883c5713e141bb',
        // l: 'OIL AND NATURAL GAS CORPORATION:ENTERP:ONGC Paperless Meetings::B+:AMS(20200620):4785AA300427080A3360B13AC982537820612FCD7EE3F5B21ED5DEC6DF95D377D969BEF5C7',
    }, viewerElement);

    var viewerInstance = null;
    var annotManager = null;


    // We need to wait for the viewer to be ready before we can use any APIs
    viewerElement.addEventListener('ready', function() {
        var viewerInstance = myWebViewer.getInstance(); // instance is ready here
        
        //viewerInstance.disableElement('downloadButton');
        viewerInstance.disableElement('menuButton');
        viewerInstance.disableElement('freeHandToolGroupButton');

        docViewer = viewerInstance.docViewer;
        annotManager = docViewer.getAnnotationManager();

        viewerInstance.setHeaderItems(function(header) {
            header.push({
            type: 'actionButton',
            img: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>',
            onClick: function() {
                // Save annotations when button is clicked
                var xfdfString = annotManager.exportAnnotations();

                axios.post("/annotate/{{ $portal }}/{{ $agenda->id }}/{{ $document }}" , {
                    body: xfdfString
                })
                .then(function(res){
                    console.log(res);
                    swal("Succesfully Saved!", "Annotations are saved privately", "success");
                });
            }
            });
        });

    });

    viewerElement.addEventListener('documentLoaded', function() {
        axios.get("/annotate/{{ $portal }}/{{ $agenda->id }}/{{ $document }}")
        .then(function(res){
            if( res.data != '404' ) {
                var xfdfString  = res.data;
                var annotations = annotManager.importAnnotations(xfdfString);
                annotManager.drawAnnotationsFromList(annotations);
            }
        })
    });


    </script>
    
</body>
</html>
