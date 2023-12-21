<?php
session_start();
if (!isset($_SESSION['username2'])) {
    echo 'Attempting to redirect...';
    header('Location: userver.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Data Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function makeRequest(url, method, callback) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        callback(null, xhr.responseText);
                    } else {
                        callback('Error: ' + xhr.status);
                    }
                }
            };

            xhr.open(method, url);
            xhr.send();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('search-input');
            var searchResultsContainer = document.getElementById('search-results-container');

            function updateSearchResults(query) {
                if (query !== '') {
                    makeRequest('proses_pencarian.php?query=' + query, 'GET', function(err, data) {
                        if (!err) {
                            searchResultsContainer.innerHTML = data;
                        } else {
                            console.error('Error:', err);
                        }
                    });
                } else {
                    searchResultsContainer.innerHTML = '';
                }
            }

            searchInput.addEventListener('input', function() {
                updateSearchResults(searchInput.value);
            });

            var searchForm = document.getElementById('search-form');
            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                updateSearchResults(searchInput.value);
            });
        });
    </script>



    <style>
        .search-results {
            margin: 20px;
        }

        .search-results table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        .search-results th,
        .search-results td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        .search-results th {
            background-color: #f2f2f2;
        }

        .search-form {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>


</head>

<body class="bg-gray-300">
    <nav class="navbar fixed-up navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Cashier App</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="main.php">Main Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="form.php">Isi Formulir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cari.php">Cari Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage.php">Atur Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-4">Pencarian Data Profil</h1>
        <div class="search-form">
            <form id="search-form" action="" method="get">
                <div class="input-group">
                    <input type="text" id="search-input" name="query" class="form-control" placeholder="Cari Nama">

                </div>
            </form>
        </div>
        <div id="search-results-container" class="search-results">
            <!-- Container untuk menampilkan hasil pencarian -->
        </div>


    </div>
    <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-text">
                &copy; <?php echo date("Y"); ?> Made by Rico Mesias Tamba
            </span>
        </div>
    </nav>
</body>


</html>