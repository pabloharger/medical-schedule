<?php class L {
const header_clinicName = 'Sua Clínica';
const header_menu_dentist = 'Dentista';
const header_menu_patient = 'Paciente';
const header_menu_schedule = 'Agenda';
const header_menu_signOut = 'Sair';
const index_welcome = 'Bem vido, %s!';
const interface_button_save = 'Salvar';
const interface_button_new = 'Novo';
const interface_button_clear = 'Limpar';
const interface_button_delete = 'Apagar';
const interface_button_signIn = 'Entrar';
const interface_button_send = 'Enviar';
const interface_button_resend = 'Reenviar';
const interface_button_close = 'Fechar';
const interface_button_add = 'Adicionar';
const interface_label_signUp = 'Registrar';
const interface_label_email = 'Email';
const interface_label_password = 'Senha';
const interface_label_repeatPassword = 'Confirmação Senha';
const interface_label_firstName = 'Nome';
const interface_label_lastName = 'Sobrenome';
const interface_label_forgotPassword = 'Esqueceu a senha?';
const interface_label_resendActivationCode = 'Reenviar código de ativação';
const interface_label_docNumber = 'Número Documento';
const interface_waring_informEmail = 'Informe o email';
const interface_waring_informPassword = 'Informe a senha';
const interface_waring_informFirstName = 'Informe o nome';
const interface_waring_informLastName = 'Informe o sobrenome';
const interface_waring_informDentist = 'Informe o dentista';
const interface_waring_informPatient = 'Informe o paciente';
const interface_waring_informInitialTime = 'Informe a hora inicial';
const interface_waring_informFinalTime = 'Informe a hora final';
const interface_info_userHasBeenRegistered = 'Usuário registrado, ative sua conta com o e-mail que lhe foi enviado para você';
const interface_info_passwordHasBeenSentFollowInstructions = 'Email enviado! Verifique o email enviado e siga as instruções';
const interface_info_passwordChangedSuccessfully = 'Senha alterada com sucesso';
const interface_info_accountActivatedSuccessfully = 'Sua conta foi ativada com sucesso';
const interface_info_dentistSaved = 'Dentista gravado';
const interface_info_patientSaved = 'Paciente gravado';
const interface_info_scheduleSaved = 'Agendamento gravado';
const interface_info_dentistNotFound = 'Dentist código %n não encontrado';
const interface_info_patientNotFound = 'Patient código %n não encontrado';
const interface_info_ScheduleNotFound = 'Schedule código %n não encontrado';
const interface_signIn_signIn = 'Acessar sua conta';
const interface_resetPassowrd_redefinePassword = 'Redefina sua senha';
const interface_dentist_selectADentist = 'Selecione um dentista';
const interface_patient_phoneNumber = 'Telefone';
const interface_patient_mobileNumber = 'Celular';
const interface_patient_address = 'Endereço';
const interface_patient_city = 'Cidade';
const interface_patient_state = 'Estado';
const interface_patient_zipCode = 'CEP';
const interface_schedule_addSchedule = 'Adicionar Agendamento';
const interface_schedule_initialTime = 'Hora Início';
const interface_schedule_finalTime = 'Hora Fim';
const interface_schedule_obs = 'Observação';
public static function __callStatic($string, $args) {
    return vsprintf(constant("self::" . $string), $args);
}
}
function L($string, $args=NULL) {
    $return = constant("L::".$string);
    return $args ? vsprintf($return,$args) : $return;
}