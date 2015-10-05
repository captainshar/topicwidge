<!-- this Request variable is  Symfony\Component\HttpFoundation\Request

Erika Heidi [11:31 AM]
so you'll need to include a USE statement in the top of the file

Erika Heidi [11:31 AM]
use Symfony\Component\HttpFoundation\Request; -->

<!-- the variables the go inside the anonymous function call ->  
function (Request $request) <- are treated in a special way by Silex.
In this case, it will just make the Request available for your anonymous function
(which is, in fact, a controller) -->

<!-- you just need to change the form method.

so it will be <form method="GET"

the link would looks something like this:

	http://asdasasd.asda/search/?parameter=asdasdas -->

<!--

	when you access the page, the app->run will execute, 
	then it will match the route you used (/) and execute that block - 
	so the twig template will be rendered -->

$app->get('/', function(Request $request) use ($app) {
   $parameter = $request->query->get('parameter');
   
   // do all your logic here - use guzzle to make a search, etc. No output yet
   
   return $app['twig']->render('template.twig', [
      'variable1' => $variable1,
      'variable2' => $variable2, //etc
   ]);
});