@extends("import_maison_data")
@section('title', 'Classement graphe')
@section("classement")
<div class="row pt-3">
    <div class="col-12">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Voir le résultat de chaque équipe</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Rang</th>
                                        <th>Equipe</th>
                                        <th>Points</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classement as $participant)
                                        <tr>
                                            <td>{{ $participant->rang }}</td>
                                            <td>Equipe {{ $participant->nom_equipe }}</td>
                                            <td>{{ $participant->totals }} points</td>
                                            @if ($participant->rang == 1)
                                            <td>
                                                <a href="{{route('pdf')}}" class="btn btn-outline-danger px-2">Pdf</a>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Voir le résultat de chaque équipe par catégorie</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="categorieTab1" role="tablist">
                            @foreach ($result as $categorie => $details)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab1-{{ $categorie }}" data-bs-toggle="tab"
                                        data-bs-target="#content1-{{ $categorie }}" type="button" role="tab" aria-controls="content1-{{ $categorie }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $categorie }}</button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="categorieTabContent1">
                            @foreach ($result as $categorie => $details)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content1-{{ $categorie }}" role="tabpanel" aria-labelledby="tab1-{{ $categorie }}">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Rang</th>
                                                <th>Equipe</th>
                                                <th>Catégorie</th>
                                                <th>Points</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($details as $participant)
                                                <tr>
                                                    <td>{{ $participant->rang }}</td>
                                                    <td>Equipe {{ $participant->nom_equipe }}</td>
                                                    <td>{{ $participant->nom_categorie }}</td>
                                                    <td>{{ $participant->points_equipe }} points</td>
                                                    @if ($participant->rang == 1)
                                                        <td><a href="{{route('pdf_categorie', ['equipe'=>$participant->nom_equipe, 'cat'=>$participant->nom_categorie, 'totals' => $participant->points_equipe ])}}" class="btn btn-outline-danger">PDF</a></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p></p>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Graphe classement général par équipe</h4>
                    </div>
                    <canvas id="pointsPieChart" width="100px" class="mb-3 p-3"></canvas>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Voir le résultat de chaque équipe par catégorie</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="categorieTab2" role="tablist">
                            @foreach ($result as $categorie => $details)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab2-{{ $categorie }}" data-bs-toggle="tab"
                                        data-bs-target="#content2-{{ $categorie }}" type="button" role="tab" aria-controls="content2-{{ $categorie }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $categorie }}</button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="categorieTabContent2">
                            @foreach ($result as $categorie => $details)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content2-{{ $categorie }}" role="tabpanel" aria-labelledby="tab2-{{ $categorie }}">
                                    <div>
                                        <canvas id="chart-{{ $categorie }}" ></canvas>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var ctx = document.getElementById('pointsPieChart').getContext('2d');

        // Préparation des données et des légendes
        var equipes = @json($classement->pluck('nom_equipe'));
        var points = @json($classement->pluck('totals'));
        var data = {
            labels: equipes.map((equipe, index) => `Equipe ${equipe} (${points[index]} totals)`),
            datasets: [{
                data: points,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
            }]
        };

        var pointsPieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    title: {
                        display: true,
                    },
                    datalabels: {
                        formatter: (value, context) => {
                            return `${value} pts`;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 16
                        }
                    }
                }
            },
        plugins: [ChartDataLabels]
        });

        @foreach ($result as $categorie => $class)
            var ctx_{{ $categorie }} = document.getElementById('chart-{{ $categorie }}').getContext('2d');

            var labels_{{ $categorie }} = {!! json_encode(array_column($class, 'nom_equipe')) !!};
            var points_{{ $categorie }} = {!! json_encode(array_column($class, 'points_equipe')) !!};

            var data_{{ $categorie }} = {
                labels: labels_{{ $categorie }}.map((equipe, index) => `Equipe ${equipe} (${points_{{ $categorie }}[index]} points)`),
                datasets: [{
                    data: points_{{ $categorie }},
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                }]
            };

            var pointsPieChart_{{ $categorie }} = new Chart(ctx_{{ $categorie }}, {
                type: 'pie',
                data: data_{{ $categorie }},
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right',
                            labels: {
                                font: {
                                    size: 14
                                }
                            }
                        },
                        title: {
                            display: true,
                        },
                        datalabels: {
                            formatter: (value, context) => {
                                return `${value} pts`;
                            },
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 16
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
            @endforeach
    </script>
</div>
@endsection
