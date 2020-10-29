function decryptPassword(id) {
    document.getElementById('encryptedPasswordLabel'+id).hidden = 'hidden';
    document.getElementById('decryptedPasswordLabel'+id).hidden= '';
    document.getElementById('decryptPasswordButton'+id).hidden='hidden';
    document.getElementById('encryptPasswordButton'+id).hidden='';
}
function encryptPassword(id) {
    document.getElementById('encryptedPasswordLabel'+id).hidden = '';
    document.getElementById('decryptedPasswordLabel'+id).hidden= 'hidden';
    document.getElementById('encryptPasswordButton'+id).hidden='hidden';
    document.getElementById('decryptPasswordButton'+id).hidden='';
}
