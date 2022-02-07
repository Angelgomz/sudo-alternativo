<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
Use Auth;
Use Session;
Use DB; 
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recheckToken($User)
    {
        if(!empty($User['params'])){  
            $User = $User['params'];
        }
        $token = $User['token'];
        $id = $User['id_user'];
        $query = DB::table('oauth_access_tokens')->where('id','=',$token)->where('user_id','=',$id)->where('revoked','=',0)->get();
       
        return $query;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function storeBd($items){
        foreach($items as $item){
            $ifExists = Evento::firstWhere('id_google',$item['id_google']);
            if(empty($ifExists)){
            $item['begin'] = strtotime($item['begin']); 
            $item['end'] = strtotime($item['end']); 
            $item['created_at'] = strtotime($item['created_at']); 
            $item['begin'] = date("Y-m-d h:m:s", $item['begin']);
            $item['end'] = date("Y-m-d h:m:s", $item['end']);
            $item['created_at'] = date("Y-m-d h:m:s", $item['created_at']);
            $evento = new Evento();
            $evento->id_google = $item['id_google'];
            $evento->nombre = $item['nombre'];
            $evento->tipo_evento =  $item['tipo_evento'];
            $evento->eTag = $item['eTag'];
            $evento->description = $item['description'];
            $evento->update_google = $item['update_google'];
            $evento->created_by = Session::get('id');
            $evento->email_creator =  $item['email_creator'];
            $evento->begin =  $item['begin'];
            $evento->end =  $item['end'];
            $evento->fecha = $item['created_at'];
            $evento->status = $item['status'];
            $evento->created_por = $item['created_at'];
            $evento->status = $item['status'];
            $evento->isActive = 1;
            $evento->save();
            }
        }
}
public function store(Request $request)
{
    //
}

/**
 * Display the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function show($id)
{
    //
}

/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function edit($id)
{
    //
}

/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $id)
{
    //
}

/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function destroy($id)
{
    Evento::where('id_google', '=',$id)->delete();
}
public function getClient(){
    $client = new \Google_Client();
    $client->setScopes(\Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig($_SERVER['DOCUMENT_ROOT'].'/sudo/vendor/google/apiclient/src/credentials.json');
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
    }
    $client->setAccessToken($accessToken);
    return $client;
}
public function saveEventInGoogleCalendar(Request $request)
{
    try {
    $token = $this->recheckToken($request->all());
    if(count($token) > 0){
    $data = $request->all();  
    if(!empty($data['params'])){  
    $data = $data['params'];
    }
    $client = $this->getClient();
    $fecha = strtotime($data['fecha']); 
    $begin = strtotime($data['begin']); 
    $end = strtotime($data['fecha'].' '.$data['end']); 
    $fecha = date("Y-m-d", $fecha);
    $begin = date("h:m:s",$begin);
    $end = date("h:m:s", $end);
    $begin = $fecha.'T'.$begin.'-03:00';
    $end = $fecha.'T'.$end.'-03:00';
    $service = new \Google_Service_Calendar($client);
    $event = new \Google_Service_Calendar_Event(array(
        'summary' => $data['nombre'],
        'description' => $data['description'],
        'start' => array(
          'dateTime' => $begin,
          'timeZone' => 'America/Santiago',
        ),
        'end' => array(
          'dateTime' => $end,
          'timeZone' => 'America/Santiago'
        ),
       /* 'attendees' => array(
          array('email' => 'lpage@example.com'),
          array('email' => 'sbrin@example.com'),
        ), */ 
        'reminders' => array(
          'useDefault' => FALSE,
          'overrides' => array(
            array('method' => 'email', 'minutes' => 24 * 60),
            array('method' => 'popup', 'minutes' => 10),
          ),
        ),
      ));
      $calendarId = 'primary';
      $event = $service->events->insert($calendarId, $event);
      $item = [['id_google' =>  $event->getId(),
      'nombre' =>  $event->getSummary(),
      'tipo_evento' =>  $event->getKind(),
      'eTag' =>  $event->getetag(),
      'description' =>  $event->getDescription(),
      'update_google'=>  $event->getUpdated(),
      'email_creator' =>  $event->getCreator()->email,
      'begin'=>  $event->getStart()->dateTime,
      'end' =>  $event->getEnd()->dateTime,
      'created_at'=> $event->getCreated(),
      'status' => $event->getStatus()]];
       $this->storeBd($item);
      return response()->json(['success'=>true,'event'=>$event]);
    }
    else{
        return response()->json(['message'=>'No está autorizado para realizar esa acción']);
    }
    }
    catch (Exception $e) {
        return response()->json(['success'=>false]);
    }
}
public function deleteEventInGoogleCalendar(Request $request)
{
    try {
        $token = $this->recheckToken($request->all());
        if(count($token) > 0){
        $data = $request->all();
        if(!empty($data['params'])){  
        $data= $data['params'];
        }
        $id = $data['id'];
        $id_user = $data['id_user'];
        $client = $this->getClient();
        $service = new \Google_Service_Calendar($client);
        $event = $service->events->delete('primary',$id);    
        $this->destroy($id);
        return response()->json(['success'=>true,'event'=>'']);
        }
        else{
            return response()->json(['message'=>'No está autorizado para realizar esa acción']);
        }

    }
    catch (Exception $e) {
        return response()->json(['success'=>false]);
    }
}
public function editEventInGoogleCalendar(Request $request){
    try {
        $token = $this->recheckToken($request->all());
        if(count($token) > 0){
        $data = $request->all();  
        if(!empty($data['params'])){  
        $data = $data['params'];
        }
        $id = $data['id'];
        $nombre = $data['nombre'];
        $descripcion = $data['descripcion'];
        $id_user = $data['id_user'];
        $fecha = strtotime($data['fecha']); 
        $begin = strtotime($data['begin']); 
        $end = strtotime($data['fecha'].' '.$data['end']); 
        $fecha = date("Y-m-d", $fecha);
        $begin = date("h:m:s",$begin);
        $end = date("h:m:s", $end);
        $begin = $fecha.'T'.$begin.'-03:00';
        $end = $fecha.'T'.$end.'-03:00';
        $client = $this->getClient();
        $service = new \Google_Service_Calendar($client);
        $event = $service->events->get('primary',$id);
        $event->setSummary($nombre);
        $event->setDescription($descripcion);
        $endevent = new \Google_Service_Calendar_EventDateTime();
        $endevent->setTimeZone('America/Santiago');
        $endevent->setDateTime($end);
        $beginevent = new \Google_Service_Calendar_EventDateTime();
        $beginevent->setTimeZone('America/Santiago');
        $beginevent->setDateTime($begin);
        $event->setStart($beginevent);
        $event->setEnd($endevent);
        $updatedEvent = $service->events->update('primary', $event->getId(), $event);
        $update = $updatedEvent->getUpdated();
        return response()->json(['success'=>true,'update'=>$update,'event'=>$event]);
        }
        else{
            return response()->json(['message'=>'No está autorizado para realizar esa acción']);
        }
    }
    catch (Exception $e) {
        return response()->json(['success'=>false]);
    }
}
public function getEventsPrimary(Request $request){
    $token = $this->recheckToken($request->all());
    if(count($token) > 0){
    $client = $this->getClient();
    $service = new \Google_Service_Calendar($client);
    $calendarId = 'primary';
    $events = $service->events->listEvents('primary');
    $items = [];
    while(true) {
        $i = 0;
      foreach ($events->getItems() as $event) {
         if(!empty($event->getSummary())){
         $items[$i] = [
          'id_google' =>  $event->getId(),
           'nombre' =>  $event->getSummary(),
           'tipo_evento' =>  $event->getKind(),
           'eTag' =>  $event->getetag(),
           'description' =>  $event->getDescription(),
           'update_google'=>  $event->getUpdated(),
           'email_creator' =>  $event->getCreator()->email,
           'begin'=>  $event->getStart()->dateTime,
           'end' =>  $event->getEnd()->dateTime,
           'created_at'=> $event->getCreated(),
           'status' => $event->getStatus()];
         $i++;
         }
      }
      $pageToken = $events->getNextPageToken();
      if ($pageToken) {
        $optParams = array('pageToken' => $pageToken);
        $events = $service->events->listEvents('primary', $optParams);
      } else {
        break;
      }
    }
    $this->storeBd($items);
    return response()->json($items);
    }
    else{
        return response()->json(['message'=>'No está autorizado para realizar esa acción']);
    }
}
}