document.addEventListener('DOMContentLoaded', function(){
    
    iniciarApp();

})    

src="https://cdn.jsdelivr.net/npm/sweetalert2@11">


function iniciarApp(){
    
    crearGaleria();
    
}





function crearGaleria(){
    const galeria = document.querySelector('.galeria-imagenes'); 

    for(let i = 1; i <= 12; i++){
        const imagen = document.createElement('picture');
        imagen.innerHTML = `
        <source srcset="build/img/thumb/${i}.avif" type="image/avif">
        <source srcset="build/img/thumb/${i}.webp" type="image/webp">

        <img loading="lazy" width="200" height="300" src="build/img/thumb/${i}.jpg" alt="imagen galeria">`;

        imagen.onclick = function(){
            mostrarImagen(i);
        }

      galeria.appendChild(imagen);
}

}

function mostrarImagen(id){
    const imagen = document.createElement('picture');
    imagen.innerHTML = `
    <source srcset="build/img/grande/${id}.avif" type="image/avif">
    <source srcset="build/img/grande/${id}.webp" type="image/webp">

    <img loading="lazy" width="200" height="300" src="build/img/grande/${id}.jpg" alt="imagen galeria">`;

    //Crear el overlay con la imagen
    const overlay = document.createElement('DIV');
    overlay.appendChild(imagen);
    overlay.classList.add('overlay');
    overlay.onclick = function(){
        const body = document.querySelector('body');
        body.classList.remove('fijar-body');
        overlay.remove();
    }

    //Boton para cerrar al modal
    const cerrarModal = document.createElement('P');
    cerrarModal.textContent = 'X';
    cerrarModal.classList.add('btn-cerrar');
    cerrarModal.onclick = function(){
        const body = document.querySelector('body');
        body.classList.remove('fijar-body');
        overlay.remove();
    }

    overlay.appendChild(cerrarModal);

//Lo añade al html
    const body = document.querySelector('body');
    body.appendChild(overlay);

    body.classList.add('fijar-body');
}




function generarPDF() {
    var doc = new jsPDF();
    doc.autoTable({ html: '.comprobantes' });
    doc.save('reporte.pdf');
}



  
