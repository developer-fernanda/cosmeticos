// jQuery(document).ready( function($) {
//     if ($("div.wcpix-response-output")){
//         console.log('div mensagem existe');
//     }
// });

// jQuery( "img.wcpix-img-copy-code" ).click(function($) {
//     let is_copied = copyCode();
//     if (is_copied){
//         if ($("div.wcpix-response-output")){
//             $("div.wcpix-response-output").show();
//         }else{
//             alert('Code copiado!');
//         }
//     }else{
//         alert('Erro ao copiar');
//     }
// });

// function copyCode() {
//     try {
//         var copyText = document.getElementById("copiar");
//         copyText.type = "text";
//         copyText.select();
//         copyText.setSelectionRange(0, 99999);
//         document.execCommand("copy"); 
//         copyText.type = "hidden";
//         return true;
//     }
//     catch (e) {
//         console.log(e);
//         return false;
//     }
// }