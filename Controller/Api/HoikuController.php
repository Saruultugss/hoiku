<?php
class HoikuController extends BaseController
{
    /**
     * "/hoiku/list" Endpoint - Get list of hoiku
     */
    public function listAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                
                $pdo = new PDO('mysql:host=localhost;dbname=kindergarden','root','');
                $sql = 'SELECT  id, facility_name, address_prefecture, address_district, address_street ,latitude, longitude FROM facility LIMIT 10';
                
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }

                $stmt = $pdo->prepare($sql);

                $stmt->execute();

                $arrHoiku = [];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    array_push($arrHoiku, $row);
                }
                $pdo = null;
                
 
                $responseData = json_encode($arrHoiku);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}