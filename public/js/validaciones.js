function validateDate(testdate) {
    var date_regex = /(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/
    return date_regex.test(testdate);
}
function validateHours(testdate) {
    var date_regex = /^([01][0-9]|2[0-3]):([0-5][0-9]:([0-5][0-9]))$/
    return date_regex.test(testdate);
}
function validateDescripcion(testdate) {
    var date_regex = /^[a-z\d\-_\s]+$/i
    return date_regex.test(testdate);
}