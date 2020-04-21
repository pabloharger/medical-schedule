<?php class L {
const header_clinicName = 'Your Clinic';
const header_menu_dentist = 'Dentist';
const header_menu_patient = 'Patient';
const header_menu_schedule = 'Schedule';
const header_menu_signOut = 'Sign Out';
const index_welcome = 'Welcome, %s!';
const interface_button_save = 'Save';
const interface_button_new = 'New';
const interface_button_clear = 'Clear';
const interface_button_delete = 'Delete';
const interface_button_signIn = 'Sign In';
const interface_button_send = 'Send';
const interface_button_resend = 'Resend';
const interface_button_close = 'Close';
const interface_button_add = 'Add';
const interface_label_signUp = 'Sign Up';
const interface_label_email = 'Email';
const interface_label_password = 'Password';
const interface_label_repeatPassword = 'Repeat Password';
const interface_label_firstName = 'First Name';
const interface_label_lastName = 'Last Name';
const interface_label_forgotPassword = 'Forgot your password?';
const interface_label_resendActivationCode = 'Resend activation code';
const interface_label_docNumber = 'Doc. Number';
const interface_waring_informEmail = 'Inform the email';
const interface_waring_informPassword = 'Inform the password';
const interface_waring_informFirstName = 'Inform the first name';
const interface_waring_informLastName = 'Inform the last name';
const interface_waring_informDentist = 'Inform the dentist';
const interface_waring_informPatient = 'Inform the patient';
const interface_waring_informInitialTime = 'Inform the initial time';
const interface_waring_informFinalTime = 'Inform the final time';
const interface_info_userHasBeenRegistered = 'User has been registered, please activate your account with the email which has been sent to your email';
const interface_info_passwordHasBeenSentFollowInstructions = 'E-mail has been sent! Verify your email and follow the instructions';
const interface_info_passwordChangedSuccessfully = 'Password changed successfully!';
const interface_info_accountActivatedSuccessfully = 'your account has been activated successfully';
const interface_signIn_signIn = 'Sign In';
const interface_resetPassowrd_redefinePassword = 'Redefine your password';
const interface_dentist_selectADentist = 'Select a dentist';
const interface_patient_phoneNumber = 'Phone Number';
const interface_patient_mobileNumber = 'Mobile Phone Number';
const interface_patient_address = 'Address';
const interface_patient_city = 'City';
const interface_patient_state = 'State';
const interface_patient_zipCode = 'Zip Code';
const interface_schedule_addSchedule = 'Add Schedule';
const interface_schedule_initialTime = 'Initial Time';
const interface_schedule_finalTime = 'Final Time';
const interface_schedule_obs = 'Observation';
public static function __callStatic($string, $args) {
    return vsprintf(constant("self::" . $string), $args);
}
}
function L($string, $args=NULL) {
    $return = constant("L::".$string);
    return $args ? vsprintf($return,$args) : $return;
}