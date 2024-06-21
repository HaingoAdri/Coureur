<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Certificat categorie</title>

    <link rel="canonical" href="index.html">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        body {
            font-size: larger;
            font-family: cursive;
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="heroes.css" rel="stylesheet">
</head>
<body>
<main>
    <div class="px-4 py-5 my-5 text-center" id="pdf_test" heigth="250">
        <h6 class="display-5 fw-bold mb-5">
            🏃🏃
            {{$course[0]->nom}} certification
            🏃🏃
        </h6>
        <img class="d-block mx-auto mb-5" src="{{asset('course.png')}}" alt="" width="800" height="210">
        <h3 class="fw-bold">🏅 Félicitation à l'Equipe {{$equipe}} 🏅</h3>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">Ce certificat revient à l'<b>Equipe {{$equipe}}</b> qui ont réussi pour le classement pour la catégorie {{$cat}}.</p>
            <p></p>
            <h4 class="col-9 text-center ml-5 fw-bold" style="margin-left: 100px;">
                Délivrée par le sponsort officiel de la course le {{$course[0]->date_debut}}.
            </h4>
            <div class="row mt-5">
                <div class="col-6 justify-content-start">
                    <h5>Total points: {{$totals}} points 🎢.</h5>
                </div>
                <div class="col-6 justify-content-end">
                    <h5>Fait le 20 Mai 2024</h5>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Ajouter un bouton pour télécharger en PDF -->
<div class="text-center">
    <button id="downloadPdf" class="btn btn-primary">Télécharger en PDF</button>
</div>

<!-- Inclure html2pdf.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    document.getElementById('downloadPdf').addEventListener('click', function() {
        var element = document.getElementById('pdf_test'); // Sélectionnez l'élément que vous voulez convertir en PDF
        var opt = {
            margin: 1,
            filename: 'Gagnant_categorie_{{$cat}}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: 'in', format: [19, 10.9], orientation: 'landscape' }
        };

        // Convertit l'élément en PDF
        html2pdf().from(element).set(opt).save();
    });
</script>
</body>
</html>
