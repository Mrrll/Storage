# Storage
Manejo del almacenamiento en laravel

<a name="top"></a>

## Indice de Contenidos.

- [Modificación del sistema de almacenamiento](#item1)
- [Modelo y migración para el manejo de los archivos](#item2)
- [Request para el manejo de las validaciones](#item3)
- [Controlador para el manejo de los archivos](#item4)
- [Rutas para el manejo de los archivos](#item5)
- [Vistas para mostrar y guardar los archivos](#item6)
- [Almacenar los archivos en la carpeta publica](#item7)
- [Almacenar los archivos en la carpeta storage](#item8)
- [Almacenar los archivos en la carpeta storage/public](#item9)
- [Almacenar en storage y visualización](#item10)

<a name="item1"></a>

## Modificación del sistema de almacenamiento.

> Abrimos el archivo `.env`.

```
FILESYSTEM_DISK=local

```

[Subir](#top)

<a name="item2"></a>

## Modelo y migración para el manejo de los archivos.

> Typee: en la Consola:

```console

php artisan make:model Info --migration

```
> Abrimos la migración generada.

```php

$table->string("name")->nullable();
$table->string("file_uri")->nullable();

```
> Abrimos el modelo info.

```php

protected $guarded = [];

```

> Typee: en la Consola:

```console

php artisan migrate

```

[Subir](#top)

<a name="item3"></a>

## Request para el manejo de las validaciones.

> Typee: en la Consola:

```console

php artisan make:request InfoRequest

```

> Abrimos el request en rules.

```php

'name' => ['nullable', 'max:100'],
'file' => ['nullable', File::image()->max(10 * 1024)]

```

[Subir](#top)

<a name="item4"></a>

## Controlador para el manejo de los archivos.

> Typee: en la Consola:

```console

php artisan make:controller InfoController

```

> Abrimos el controlador.

```php

    public function index(){
        $infos = Info::get();
        return view('index', compact('infos'));
    }
    public function create(){
        return view('create');
    }
    public function store(InfoRequest $request){

    }

```

[Subir](#top)

<a name="item5"></a>

## Rutas para el manejo de los archivos.

> Abrimos el archivo web de rutas.

```php

Route::get('/', [InfoController::class, 'index'])->name('index');
Route::get('/create', [InfoController::class, 'create'])->name('create');
Route::post('/store', [InfoController::class, 'store'])->name('store');

```

[Subir](#top)

<a name="item6"></a>

## Vistas para mostrar y guardar los archivos.

> Creamos y Abrimos el archivo index en las vistas.

```html

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <a href="{{route('create')}}">Create</a>
    <ul>
        @forelse ($infos as $info)
        <li><img src="{{ asset('images/' . $info->file_uri) }}" alt="{{ $info->name }}" width="128px"></li>
        @empty
            <li>No data.</li>
        @endforelse
    </ul>
</body>
</html>

```

> Creamos y Abrimos el archivo create en las vistas.

```html

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <a href="{{route('index')}}">Back to index</a>
    <form action="{{route('store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" placeholder="Name" />
        <input type="file" name="file" placeholder="File" />
        <input type="submit" value="send">
    </form>
</body>
</html>

```

### Inicializamos nuestra aplicación

> Typee: en la Consola:

```console

php artisan serve

```

[Subir](#top)

<a name="item7"></a>

## Almacenar los archivos en la carpeta publica.

> Abrimos el controlador en store.

```php
$fileName = time() . '.' . $request->file->extension();
$request->file->move(public_path('images'), $fileName);
$info = new Info;
$info->name = $request->name;
$info->file_uri = $fileName;
$info->save();
return redirect()->route('index');
```
[Subir](#top)

<a name="item8"></a>

## Almacenar los archivos en la carpeta storage.

> Abrimos el controlador en store.

```php
$fileName = time() . '.' . $request->file->extension();
$request->file->storeAs('images', $fileName);
$info = new Info;
$info->name = $request->name;
$info->file_uri = $fileName;
$info->save();
return redirect()->route('index');
```
**`NOTA::` No se puede la visualización de los archivos en la carpeta storage ya que es una carpeta privada.**

[Subir](#top)

<a name="item9"></a>

## Almacenar los archivos en la carpeta storage/public.

> Abrimos el controlador en store.

```php
$fileName = time() . '.' . $request->file->extension();
$request->file->storeAs('public/images', $fileName);
$info = new Info;
$info->name = $request->name;
$info->file_uri = $fileName;
$info->save();
return redirect()->route('index');
```
**`NOTA::` Para la visualización de los archivos en la carpeta storage/public hay que crear un link simbólico.**

> Typee: en la Consola:

```console

php artisan storage:link

```
> Abrimos el archivo index en las vistas.

```html

    <li><img src="{{ asset('storage/images/' . $info->file_uri) }}" alt="{{ $info->name }}" width="128px"></li>

```

[Subir](#top)

**`Agradecimientos:` Por el Tutorial [GOGODEV](https://www.youtube.com/watch?v=oNf33-nqleI) #13 Curso de LARAVEL profesional - FILE STORAGE.**

<a name="item10"></a>

## Almacenar en storage y visualización.

> Abrimos la vista index y cambiamos.

```html

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

```

> Abrimos la vista create y añadimos.

```html

<input type="text" name="storage" value="{{ $storage }}" readonly>

```
> Abrimos request y añadimos.

```php

'storage' => 'required|string'

```

> Abrimos el controlador en create y cambiamos.

```php

return view('create', compact('storage'));

```

> Abrimos el controlador en store y cambiamos.

```php

$route = ($request->storage == "public") ? 'public/images' : 'private/images';
$request->file->storeAs($route, $fileName);

```

**`NOTA::` He añadido una carpeta llamada private para diferenciarla con la carpeta public en la llamada.**

> Abrimos el archivo de rutas web y añadimos.

```php

Route::get('storage/private/images/{file}', function ($file) {
    $path = storage_path('app/private/images/'. $file);
    return response()->file($path);
})->name('private.images');

```
> De esta manera podemos restringir el acceso.

```php

return (Auth::check()) ?  response()->file($path) : abort(404);

```

**`NOTA::` Para la visualización de los archivos en la carpeta storage hay que hacer que la ruta coincida con la llamada.**

>Pues eso es todo espero que sirva. 👍

[Subir](#top)
