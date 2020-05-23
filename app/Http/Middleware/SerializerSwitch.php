<?php
//
//namespace App\Http\Middleware;
//
//use Closure;
//use Dingo\Api\Transformer\Adapter\Fractal;
//use Dingo\Api\Transformer\Factory;
//use League\Fractal\Manager;
//use League\Fractal\Serializer\JsonApiSerializer;
//
//class SerializerSwitch
//{
////    protected $drivers = [
////        'default_array' => 'League\Fractal\Serializer\ArraySerializer',
////        'default_data_array' => 'League\Fractal\Serializer\DataArraySerializer',
////        'json_api' => 'League\Fractal\Serializer\JsonApiSerializer',
////
////        // change null resource return null instead of []
////        'array' => 'Liyu\Dingo\Serializers\ArraySerializer',
////        'data_array' => 'Liyu\Dingo\Serializers\DataArraySerializer',
////    ];
//
//    /**
//     * Handle an incoming request.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \Closure  $next
//     *
//     * @return mixed
//     */
//    public function handle($request, Closure $next)
//    {
//        app(Factory::class)->setAdapter(
//            function ($app) {
//                $fractal = new Manager;
//                $serializer = new JsonApiSerializer;
//
//                $fractal->setSerializer($serializer);
//                return new Fractal($fractal);
//            }
//        );
//        return $next($request);
//    }
//
////    protected function getDriver($name)
////    {
////        $name = array_key_exists($name, $this->drivers) ? $name : 'data_array';
////        return $this->drivers[$name];
////    }
//
//}