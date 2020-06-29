

$GRAPH_API_VERSION = 'v6.0';
$GRAPH_API_ENDPOINT = 'https://graph.facebook.com/'.$GRAPH_API_VERSION;
$ACCESS_TOKEN_PATH = '..'.DIRECTORY_SEPARATOR.'token'.DIRECTORY_SEPARATOR.'access_token.txt';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $graph_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $output = curl_exec($ch); 
    curl_close($ch);

    //work with the lead data
    $atoken = json_decode($output);
   
  
$graph_url= "https://graph.facebook.com/v6.0/oauth/access_token?grant_type=fb_exchange_token&client_id=596932877821061&client_secret=75c24da50febdd871c68673188cde7da&fb_exchange_token=EAAIe6EQjJIUBAC9Klp7kglPAlz1XyAZCGG4KAjLqwZAMYNst7EEK9MLhRC1CP19hIcRnHD9PZCKRZCcd548rH5rQs2ZCcYrcQM4BDAWVXyTh3mzuyGiDXAFF3LaojE86mcRDHup2jEFf5cHFa113fSgamNYF2PXSEJXvHi77LdAZDZD";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $graph_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $output = curl_exec($ch); 
    curl_close($ch);
    $leaddata = json_decode($output);
   $access_token = $leaddata->access_token;

  // Get value from request body
  $countriesObj   = new Countries();
  
  $body = json_decode(file_get_contents('php://input'));
  foreach ($body->entry as $page) {
      foreach ($page->changes as $change) {
      

      // We get page, form, and lead IDs from the change here.
      // We need the lead gen ID to get the lead data.
      // The form ID and page ID are optional. You may want to record them into your CRM system.
      $page_id = $change->value->page_id;
      $form_id = $change->value->form_id;
      $leadgen_id = $change->value->leadgen_id;
      

   $graph_url= $GRAPH_API_ENDPOINT.'/'.$leadgen_id.'?access_token='.$access_token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $graph_url);
    curl_setopt($ch, CURLOPT_HEADER, array());
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $output = curl_exec($ch); 
    curl_close($ch);

    $leaddata = json_decode($output);

   
    $countriesObj->insertTest(array(
                    'data' => $output,
                ));
    }
  }
  http_response_code(200);
}
