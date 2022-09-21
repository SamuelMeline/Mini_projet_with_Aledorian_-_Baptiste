-------------------------- MODIF DES EVENTS -----------------------

CONVERTIR L'ADRESSE EN POSITION GPS (UTILISATION API ADDRESS GOUV / "https://api-adresse.data.gouv.fr/")

*PHP 

    <!-- ON RECUPERE LA POSITION VIA L'INPUT -->

    $position = $_POST['positon'];

    <!-- FAIT LA REQUETE VERS L'API -->

    $results = json_decode(file_get_contents('https://api-adresse.data.gouv.fr/search/?q='.$position), true);

    <!-- ON STOCK LES COORDONNEES DANS DES VARIABLES -->

    $longitude = $results["features"][0]["geometry"]["coordinates"][0]; 
    $latitude = $results["features"][0]["geometry"]["coordinates"][1];

    $position = $longitude . " " . $latitude;

    REQUETE SQL

    var_dump($position);


--------------------------- TRAITEMENT DES DONNEES ---------------------------

ENVOIE EN POST / GET LES COORDONEE DANS DU PHP

OUVERTURE D'UNE NOUVELLE PAGE DANS LAQUELLE JE RECUPERE LES COORDONNEES DE TOUT LES EVENTS 

ON CALCUL LA DISTANCE 

PUIS ON AFFICHE LES EVENTS IF DISTANCE < 50km


---------------------------- CODE PHP CALCUL DISTANCE -----------------------


function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2,    $longitude2, $unit = 'kilometers') {
   $theta = $longitude1 - $longitude2; 
   $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
   $distance = acos($distance); 
   $distance = rad2deg($distance); 
   $distance = $distance * 60 * 1.1515; 
   switch($unit) { 
     case 'miles': 
       break; 
     case 'kilometers' : 
       $distance = $distance * 1.609344; 
   } 
   return (round($distance,2)); 
 }