A.	Creando un sistema API REST
Instalar el paquete API de laravel
•	Ubicado en la carpeta “laravelcourse”, ejecute el siguiente comando:
Ejecutar en Terminal
php artisan install:api

•	Luego saldrá un mensaje indicando que si queremos hacer cambios en la base de datos y colocaremos “yes” 

Crear el controlador
•	Ubicado en la carpeta “app/Http/Controllers”, cree la carpeta “Api”. Luego ubicado en “app/Http/Controllers/Api”, cree el archivo ProductApiController.php con el siguiente contenido:
Añadir todo este código
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductApiController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::all();
        return response()->json($products, 200);
    }

    public function show(string $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        return response()->json($product, 200);
    }
}

Añadiendo las rutas 

•	Modifique el archivo routes/api.php según lo que se resalta en negrilla en el siguiente código:
Modifique según la negrilla
…

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', 'App\Http\Controllers\Api\ProductApiController@index')->name('api.product.index');
Route::get('/products/{id}', 'App\Http\Controllers\Api\ProductApiController@show')->name('api.product.show');

Correr la aplicación
•	Ubicado en la carpeta “laravelcourse”, ejecute el siguiente comando:
Ejecutar en Terminal
php artisan serve


•	Si todo sale bien, deberá poder acceder desde el navegador a la ruta http://127.0.0.1:8000/api/products y ver el api de productos

•	Luego, podrá ver datos de productos individuales si accede desde la ruta http://127.0.0.1:8000/api/products/1 (ver siguiente figura).

B.	Creando un sistema API REST con Recursos
Crear el recurso
•	Ubicado en la carpeta “app/Http”, cree la carpeta “Resources”. Luego ubicado en “app/Http/Resources”, cree el archivo ProductResource.php con el siguiente contenido:
Añadir todo este código
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
        ];
    }
}

Crear el controlador
•	Ubicado en la carpeta “app/Http/Controllers/Api”, cree el archivo ProductApiControllerV2.php con el siguiente contenido:
Añadir todo este código
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductApiControllerV2 extends Controller
{
    public function index(): JsonResponse
    {
        $products = ProductResource::collection(Product::all());
        return response()->json($products, 200);
    }

    public function show(string $id): JsonResponse
    {
        $product = new ProductResource(Product::findOrFail($id));
        return response()->json($product, 200);
    }
}

Añadiendo las rutas 

•	Modifique el archivo routes/api.php según lo que se resalta en negrilla en el siguiente código:
Modifique según la negrilla
…

Route::get('/products', 'App\Http\Controllers\Api\ProductApiController@index')->name('api.product.index');
Route::get('/products/{id}', 'App\Http\Controllers\Api\ProductApiController@show')->name('api.product.show');
Route::get('/v2/products', 'App\Http\Controllers\Api\ProductApiControllerV2@index')->name('api.v2.product.index');
Route::get('/v2/products/{id}', 'App\Http\Controllers\Api\ProductApiControllerV2@show')->name('api.v2.product.show');

Correr la aplicación
•	Ubicado en la carpeta “laravelcourse”, ejecute el siguiente comando:
Ejecutar en Terminal
php artisan serve

•	Si todo sale bien, deberá poder acceder desde el navegador a la ruta http://127.0.0.1:8000/api/v2/products y ver el api V2 de productos

•	Luego, podrá ver datos de productos individuales si accede desde la ruta http://127.0.0.1:8000/api/v2/products/1

C.	Creando un sistema API REST con Colecciones
Crear el recurso
•	Ubicado en la carpeta “app/Http/Resources”, cree el archivo ProductCollection.php con el siguiente contenido:
Añadir todo este código
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'additionalData' => [
                'storeName' => 'Mega Store',
                'storeProductsLink' => 'http://127.0.0.1:8000/products',
            ],
        ];
    }
}

Crear el controlador
•	Ubicado en la carpeta “app/Http/Controllers/Api”, cree el archivo ProductApiControllerV3.php con el siguiente contenido:
Añadir todo este código
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductApiControllerV3 extends Controller
{
    public function index(): JsonResponse
    {
        $products = new ProductCollection(Product::all());
        return response()->json($products, 200);
    }

    public function paginate(): JsonResponse
    {
        $products = new ProductCollection(Product::paginate(5));
        return response()->json($products, 200);
    }
}

Añadiendo las rutas 

•	Modifique el archivo routes/api.php según lo que se resalta en negrilla en el siguiente código:
Modifique según la negrilla
…

Route::get('/v2/products', 'App\Http\Controllers\Api\ProductApiControllerV2@index')->name('api.v2.product.index');
Route::get('/v2/products/{id}', 'App\Http\Controllers\Api\ProductApiControllerV2@show')->name('api.v2.product.show');
Route::get('/v3/products', 'App\Http\Controllers\Api\ProductApiControllerV3@index')->name('api.v3.product.index');
Route::get('/v3/products/paginate', 'App\Http\Controllers\Api\ProductApiControllerV3@paginate')->name('api.v3.product.paginate');



Correr la aplicación
•	Ubicado en la carpeta “laravelcourse”, ejecute el siguiente comando:
Ejecutar en Terminal
php artisan serve

•	Si todo sale bien, deberá poder acceder desde el navegador a la ruta http://127.0.0.1:8000/api/v3/products y ver el api V3 de productos 


•	Luego, podrá ver datos de productos paginados si accede desde la ruta http://127.0.0.1:8000/api/v3/products/paginate

•	Luego, podrá ver más datos de productos paginados si accede desde la ruta http://127.0.0.1:8000/api/v3/products/paginate?page=2 

D.	Testeando el API REST por fuera de Laravel
Crear el proyecto de prueba del API REST
•	Cree una carpeta por fuera del proyecto de Laravel. Llámela “test-laravel-api”.
•	Ubicado en el proyecto “test-laravel-api”, cree el archivo index.html con el siguiente contenido:
Añadir todo este código
<!DOCTYPE html>
<html>
<head>
  <title>Laravel - API test example</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" crossorigin="anonymous"></script>
</head>
<body>

<div id="infoProducts">
  
</div>
   
<script type="text/javascript">
  $.ajax({
    type: "GET",
    dataType: "json",
    url: 'http://127.0.0.1:8000/api/v3/products',
    success: function(data){
      $('#infoProducts').html(JSON.stringify(data));
    }
  });
</script>
   
</body>
</html>

Correr la aplicación
•	Abra el archivo anterior en el navegador (arrástrelo desde las carpetas de su computador a una pestaña del navegador). 


Otra manera de probar la aplicación
•	Vaya a https://resttesttest.com/
•	Coloque el link de una API que desea probar (ejemplo: http://127.0.0.1:8000/api/v2/products).
•	Dele click en “Ajax Request






