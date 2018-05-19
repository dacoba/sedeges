@if (!in_array($solicitud['estado'], array(0, 1)))
    @if(!is_null($solicitud['valoracion_trabajador_social_id']) and $solicitud['valoracion_trabajador_social']['estado'] == 1)
        <div class="modal fade" id="modalTrabajoSocial" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Valoracion Social</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <div class="row">
                                    <span class="col-sm-auto font-weight-bold">Fecha de la Valoracion:</span>
                                    <span class="col-sm-auto">{{ $solicitud['valoracion_trabajador_social']['fecha_valoracion']->format('d \d\e F \d\e\l Y')  }}</span>
                                </div>
                                <div class="row">
                                    <span class="col-sm-auto font-weight-bold">Condiciones de Vivienda:</span>
                                    <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_trabajador_social']['condiciones_vivienda'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_trabajador_social']['condiciones_vivienda'] == true ? "Favorable" : "Desfavorable" }}</span>
                                </div>
                                <div class="row">
                                    <span class="col-sm-auto font-weight-bold">Estructura Familiar:</span>
                                    <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_trabajador_social']['estructura_familiar'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_trabajador_social']['estructura_familiar'] == true ? "Favorable" : "Desfavorable" }}</span>
                                </div>
                                <div class="row">
                                    <span class="col-sm-auto font-weight-bold">Situacion Actual:</span>
                                    <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_trabajador_social']['situacion_actual'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_trabajador_social']['situacion_actual'] == true ? "Favorable" : "Desfavorable" }}</span>
                                </div>
                                <div class="row">
                                    <span class="col-sm-12 font-weight-bold">Observacion:</span>
                                    <p class="col-sm-12 text-justify">{{ $solicitud['valoracion_trabajador_social']['observacion_trabajador_social'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(!is_null($solicitud['valoracion_psicologo_id']) and $solicitud['valoracion_psicologo']['estado'] == 1)
        <div class="modal fade" id="modalPsicologo" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Valoracion Psicologica</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <div class="row">
                                    <span class="col-sm-auto font-weight-bold">Fecha de la Valoracion:</span>
                                    <span class="col-sm-auto">{{ $solicitud['valoracion_psicologo']['fecha_valoracion']->format('d \d\e F \d\e\l Y')  }}</span>
                                </div>
                                <div class="row">
                                    <span class="col-sm-auto font-weight-bold">Evaluacion Psicologica:</span>
                                    <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_psicologo']['evaluacion_psicologica'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_psicologo']['evaluacion_psicologica'] == true ? "Favorable" : "Desfavorable" }}</span>
                                </div>
                                <div class="row">
                                    <span class="col-sm-auto font-weight-bold">Dinamica Familiar:</span>
                                    <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_psicologo']['dinamica_familiar'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_psicologo']['dinamica_familiar'] == true ? "Favorable" : "Desfavorable" }}</span>
                                </div>
                                <div class="row">
                                    <span class="col-sm-auto font-weight-bold">Motivacion para Adopcion:</span>
                                    <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_psicologo']['motivacion_adopcion'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_psicologo']['motivacion_adopcion'] == true ? "Favorable" : "Desfavorable" }}</span>
                                </div>
                                <div class="row">
                                    <span class="col-sm-12 font-weight-bold">Observacion:</span>
                                    <p class="col-sm-12 text-justify">{{ $solicitud['valoracion_psicologo']['observacion_psicologo'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(!is_null($solicitud['valoracion_doctor_id']) and $solicitud['valoracion_doctor']['estado'] == 1)
        <div class="modal fade" id="modalDoctor" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Valoracion Medica</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <div class="row">
                                    <span class="col-sm-auto font-weight-bold">Fecha de la Valoracion:</span>
                                    <span class="col-sm-auto">{{ $solicitud['valoracion_doctor']['fecha_valoracion']->format('d \d\e F \d\e\l Y')  }}</span>
                                </div>
                                <div class="row">
                                    <span class="col-sm-auto font-weight-bold">Condicion Medica:</span>
                                    <span class="col-sm-auto font-weight-bold {{$solicitud['valoracion_doctor']['condicion_medica'] ? 'text-success' : 'text-danger'}}">{{$solicitud['valoracion_doctor']['condicion_medica'] == true ? "Favorable" : "Desfavorable" }}</span>
                                </div>
                                <div class="row">
                                    <span class="col-sm-12 font-weight-bold">Observacion:</span>
                                    <p class="col-sm-12 text-justify">{{ $solicitud['valoracion_doctor']['observacion_doctor'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif