$app->get('/', function(Request $request) use ($app) {
   $parameter = $request->query->get('parameter');
   
   // do all your logic here - use guzzle to make a search, etc. No output yet
   
   return $app['twig']->render('template.twig', [
      'variable1' => $variable1,
      'variable2' => $variable2, //etc
   ]);
});