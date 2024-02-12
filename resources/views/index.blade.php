<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <a href="{{ route('create', 'public') }}">Create Public</a>
    <h4>Lista de imagenes publicas</h4>
    <ul>
        @forelse ($infos as $info)
            <li><img src="{{ asset('storage/images/' . $info->file_uri) }}" alt="{{ $info->name }}" width="128px"></li>
        @empty
            <li>No data.</li>
        @endforelse
    </ul>
    <a href="{{ route('create', 'private') }}">Create Private</a>
    <h4>Lista de imagenes privadas</h4>
    <ul>
        @forelse ($infos as $info)
            <li><img src="{{ route('private.images', ['file' => $info->file_uri]) }}" alt="{{ $info->name }}"
                    width="128px"></li>
        @empty
            <li>No data.</li>
        @endforelse
    </ul>
</body>

</html>
