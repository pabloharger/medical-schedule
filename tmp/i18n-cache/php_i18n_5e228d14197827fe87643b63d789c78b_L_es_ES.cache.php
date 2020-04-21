<?php class L {
const header_clinicName = 'Su Clinica';
const header_menu_dentist = 'Dentista';
const header_menu_patient = 'Paciente';
const header_menu_schedule = 'Agenda';
const header_menu_signOut = 'Salir';
const index_welcome = '¡Bien venido, %s!';
const interface_button_save = 'Guardar';
const interface_button_new = 'Nuevo';
const interface_button_clear = 'Limpiar';
const interface_button_delete = 'Eliminar';
const interface_button_signIn = 'Entrar';
const interface_button_send = 'Enviar';
const interface_button_resend = 'Reenviar';
const interface_button_close = 'Cerrar';
const interface_button_add = 'Agregar';
const interface_label_signUp = 'Registrar';
const interface_label_email = 'Email';
const interface_label_password = 'Contraseña';
const interface_label_repeatPassword = 'Repetir Contraseña';
const interface_label_firstName = 'Nombre';
const interface_label_lastName = 'Apellido';
const interface_label_forgotPassword = '¿Olvido la contraseña?';
const interface_label_resendActivationCode = 'Reenviar código de activación';
const interface_label_docNumber = 'Número Documento';
const interface_waring_informEmail = 'Ingrese su email';
const interface_waring_informPassword = 'Ingrese su contraseña';
const interface_waring_informFirstName = 'Ingrese el nombre';
const interface_waring_informLastName = 'Ingrese el apellido';
const interface_waring_informDentist = 'Ingrese el dentista';
const interface_waring_informPatient = 'Ingrese el paciente';
const interface_waring_informInitialTime = 'Ingrese la hora inicial';
const interface_waring_informFinalTime = 'Ingrese la hora final';
const interface_info_userHasBeenRegistered = 'Usuario registrado, active su cuenta con el email que te enviamos';
const interface_info_passwordHasBeenSentFollowInstructions = '¡Email enviado! Revise el email que te enviamos y siga las instrucciones';
const interface_info_passwordChangedSuccessfully = 'La contraseña ha cambiado con éxito';
const interface_info_accountActivatedSuccessfully = 'Su cuenta se ha activado con éxito';
const interface_signIn_signIn = 'Entrar';
const interface_resetPassowrd_redefinePassword = 'Restablece tu contraseña';
const interface_dentist_selectADentist = 'Seleccione um dentista';
const interface_patient_phoneNumber = 'Telefono';
const interface_patient_mobileNumber = 'Celular';
const interface_patient_address = 'Dirección';
const interface_patient_city = 'Ciudad';
const interface_patient_state = 'Estado';
const interface_patient_zipCode = 'Codigo Postal';
const interface_schedule_addSchedule = 'Agregar horario';
const interface_schedule_initialTime = 'Hora Inicial';
const interface_schedule_finalTime = 'Hora Final';
const interface_schedule_obs = 'Observación';
public static function __callStatic($string, $args) {
    return vsprintf(constant("self::" . $string), $args);
}
}
function L($string, $args=NULL) {
    $return = constant("L::".$string);
    return $args ? vsprintf($return,$args) : $return;
}