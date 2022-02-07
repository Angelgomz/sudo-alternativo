@include ('layouts.main')
        <input type="hidden" id="id_user" value="{{Session::get('id')}}">
        <div class="modal" id="modalEvent" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Crear Evento:</h5>
                            <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal()">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <div id="modalForm">
                                            <form class="formFecha">
                                                        <div class="form-group pt-1 pb-1">
                                                            @csrf
                                                    
                                                            <label for="name">Nombre del evento:</label>
                                                            <input type="email" class="form-control" id="name"  placeholder="Meeting with sudo team">
                                                        </div>
                                                        <div class="form-group pt-1 pb-1">
                                                            <label for="date">Fecha del evento:</label>
                                                            <input class="form-control"  class="fecha"  id="fecha" name="fecha" placeholder="28/03/22"  type="text" autocomplete="off">                                                                    
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="description">Descripcion</label>
                                                                <textarea class="form-control" id="description" rows="3"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="date">Hora:</label>
                                                        </div>
                                                        <div class="form-group d-flex pt-1 pb-1">
                                                            <input class="form-control timepicker" id="begin" name="fecha" placeholder="11:30" type="text" autocomplete="off">    
                                                            <input class="form-control timepicker" id="end" name="fecha" placeholder="12:30" type="text" autocomplete="off">   
                                                        </div>
                                            </form>
                                                        <button type="submit" id="enviarForm" class="btn btn-primary pt-2 pb-2">Enviar</button>
                            </div>
                            <div class="modalDetail">
                                                        <div class="">
                                                        <h6><strong>Nombre: </strong></h6>
                                                             <input class="form-control" id="nombreevento" type="" value=""></input>
                                                        <h6><strong>Fecha Evento: </strong></h6>
                                                            <input class="form-control" class="fecha" id="fechaevento" name="fecha" placeholder="28/03/22"  type="text" autocomplete="off"></input>   
                                                        <h6> <strong> Horario: </strong></h6>
                                                        <div class="form-group d-flex pt-1 pb-1">
                                                            <input class="form-control timepicker" id="beginalt" name="fecha"  type="text" autocomplete="off">    
                                                            <input class="form-control timepicker" id="endalt" name="fecha"  type="text" autocomplete="off">   
                                                        </div>
                                                        <h6><strong>Descripción</strong></h6>
                                                         <textarea class="form-control" id="descripcion" rows="3"></textarea>
                                                         <h6 id="reminder"></h6>
                                                         <h6 id="createdBy"></h6>
                                                         <h6>Guests:</h6>
                                                         <div id="guest"></div>
                                                        </div>
                                                         <button type="submit" id="editarCalendar" data-id="" class="btn btn-primary pt-2 pb-2" onclick="editarEvento(this)">Editar Evento</button>
                                                         <button type="submit" id="eliminarCalendar" data-id="" class="btn btn-primary pt-2 pb-2" onclick="eliminarEvento(this)">Eliminar Calendario</button>
                            </div>
                        </div>
                      
                        </div>
                    </div>
        </div>         
        @include ('layouts.navbar')
        <div class="container">
             <div class="row">
                 <div class="col-4 pt-2 pb-2">
                        <button type="button" class="btn btn-primary" id="createEvent">Crear nuevo evento</button>
                </div>
            </div>
            <div class="row">
             <div id='calendar'></div>
                <!--    <iframe src="https://calendar.google.com/calendar/embed?src=64nul8cver2kr5av1o37n3gb98%40group.calendar.google.com&ctz=America%2FCaracas" style="border: 0" width="800" height="600" frameborder="0" scrolling="no">
                  </iframe> -->
                  <input hidden id="tipo_token" value="{{Session::get('tokenLaravel')['token_type']}}"> </input>
                  <input hidden id="token" value="{{Session::get('tokenLaravel')['id']}}"> </input>
                  <input hidden id="accesstoken" value="{{Session::get('tokenLaravel')['access_token']}}"> </input>
         
            </div>
        </div>
@include ('layouts.footer')