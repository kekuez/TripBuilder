<?php
class API{
    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    public $method = '';
    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed, in our
     * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
     * or /<endpoint>/<arg0>
     */
    protected $args = Array();
    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    protected $endpoint = '';

    protected $code;
    /**
     * @var array|string
     * formatted url input
     */
    private $request = array();

    public $content_type = "application/json";

    public function __construct($request){
        $this->args = explode('/', rtrim($request, '/'));
        $endpoint = array_shift($this->args);
        $this->method = $_SERVER['REQUEST_METHOD'];
        switch($this->method) {
            case 'DELETE':
            case 'POST':
                $this->request = $this->cleanInputs($_POST);
                break;
            case 'GET':
                $this->request = $this->cleanInputs($_GET);
                break;
            case 'PUT':
                $this->request = $this->cleanInputs($_GET);
                $this->file = file_get_contents("php://input");
                break;
            default:
                $this->response('Invalid Method', 406);
                break;
        }
    }

    private function cleanInputs($data){
        $clean_input = array();
        if(is_array($data)){
            foreach($data as $k => $v){
                $clean_input[$k] = $this->cleanInputs($v);
            }
        }else{
            if(get_magic_quotes_gpc()){
                $data = trim(stripslashes($data));
            }
            $data = strip_tags($data);
            $clean_input = trim($data);
        }
        return $clean_input;
    }

    public function get_status_message(){
        $status = array(
            100 => 'Continue',
            200 => 'OK',
            400 => 'Bad Request',
            404 => 'Not Found',
            406 => 'Not Acceptable',
            500 => 'Internal Server Error'

        );
        return ($status[$this->code]) ? $status[$this->code] : $status[500];
    }
    private function set_header(){
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type:" . $this->content_type);
        header("HTTP:/1.1" . $this->code ." " . $this->get_status_message());
    }

    /**
     * @param $data
     * @param $code
     * @return string
     * delivery json response
     */
    protected function response($data, $code=200)
    {
        $this->code = ($code) ? $code : 200;
        $this->set_header();
        return json_encode($data);
    }
    public function processAPI()
    {
        if (method_exists($this, $this->endpoint)) {
            return $this->response($this->{$this->endpoint}($this->args));
        }
        return $this->response("No Endpoint: $this->endpoint", 404);
    }

    /**
     * @return string;
     * create airport list
     */
    public function createTrip(){
        $data = array();
        $data["airport"] = $this->listAirport();
        echo $this->response($data, $code=200);
    }

    /**
     * @return array
     * list all airports
     */
    public function listAirport(){
        $file_content = file_get_contents("airport.txt");
        $content = explode("\n",$file_content);
        $airport = array();
        $i = 1;
        foreach($content as $a){
                $name = explode(',',$a);
                //$airport[]["airport_id"] = $i;
                //$airport[]["airport_name"] = $name[0];
                $airport[] = array("airport_id"=>$i, "airport_name"=>$name[0]);
                $i++;
        }
        return $airport;

    }

    /**
     * @return array
     * list all available fights
     */
    public function listFlight(){
        $flight = array();
        $flight[] = array("flightId"=>1, "flightName"=> "American Airlines
Flight 3914");
        $flight[] = array("flightId"=>2, "flightName"=>"Finnair
Flight 5667");
        $flight[] = array("flightId"=>3, "flightName"=>"Air France
Flight 347");
        return $flight;
    }

    /**
     * @param $tripId
     * pass information to add flight page before submission
     */
    public function AddFlight($tripId){
        $tripId = 1;
        $tripName = "Montrel to London";
        $trip = array("tripId"=>$tripId,"tripName"=>$tripName);
        $data["flight"] = $this->listFlight();
        $data["trip"] = $trip;
        echo $this->response($data, $code=200);
    }

    /**
     * @param $tripId
     * page requirement: trip info, flight list, selected flights
     */
    public function RemoveFlight($tripId){
        $tripId = 1;
        $tripName = "Montrel to London";
        $trip = array("tripId"=>$tripId,"tripName"=>$tripName);
        $data["trip"] = $trip;
        $data["flight"] = $this->listFlight();
        $selectedFlight = array();
        $selectedFlight[] = array("flightId"=>1);
        $selectedFlight[] = array("flightId"=>2);
        $data["selectedFlight"] = $selectedFlight;
        echo $this->response($data, $code=200);
    }
    public function getRequest(){
        return $this->request;
    }

}