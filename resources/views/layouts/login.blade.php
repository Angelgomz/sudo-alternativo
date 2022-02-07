@include ('layouts.main')
        <div class="modal" id="modalEvent" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Crear Evento:</h5>
                            <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form class="formFecha">
                                    <div class="form-group pt-1 pb-1">
                                          @csrf
                                        <label for="name">Nombre del evento:</label>
                                        <input type="email" class="form-control" id="name"  placeholder="Meeting with sudo team">
                                    </div>
                                    <div class="form-group pt-1 pb-1">
                                        <label for="date">Fecha del evento:</label>
                                        <input class="form-control" id="fecha" name="fecha" placeholder="28/03/22"  type="text" autocomplete="off">                                                                    
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
                      
                        </div>
                    </div>
        </div>         
        @include ('layouts.navbar')
        <div class="container">
             <div class="row d-flex justify-content-center align-items-center">
                            
                            <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="card-title"><h6><strong>Inicio de Sesión</strong></h6></h5>
                                            <form>
                                            <div class="form-group pt-2 pb-2">
                                                <label for="exampleInputEmail1">Email:</label>
                                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="angelgomz14@gmail.com">
                                            </div>
                                            <div class="form-group pt-2 pb-2">
                                                <label for="exampleInputPassword1">Password:</label>
                                                <input type="password" class="form-control" id="********" placeholder="Password">
                                            </div>
                                                    <button type="submit" class="btn btn-primary mt-1 mb-1">ENVIAR</button>
                                                    <a href={{$urlauth}} class="btn btn-success mt-1 mb-1" >INICIAR SESION CON GOOGLE <i class="fab fa-google"></i> </a>
                                            </form>
                                    </div>
                            </div>
                </div>
        </div>
@include ('layouts.footer')