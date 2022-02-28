<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="{{ $description ?? '' }}">
        <title>{{ $title ?? '' }}</title>
    </head>
    <body>
        <h1>Bonjour <?php echo "$firstname $lastname"; ?></h1>
        <h2>Au revoir {{ $firstname }} {{ $lastname }}</h2> <!-- Curly braces = Syntaxe blade -->
    </body>
</html>
