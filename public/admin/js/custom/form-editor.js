ClassicEditor
.create( document.querySelector( '#editor-text' ), {
} )
.then( editor => {
    window.editor = editor;
} )
.catch( err => {
    console.error( err.stack );
} );
