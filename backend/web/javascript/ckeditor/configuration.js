ClassicEditor
	.create( document.querySelector( '#editor' ), {
		alignment: {
			options: [
				{ name: 'left', className: 'left-align' },
				{ name: 'center', className: 'center-align' },
				{ name: 'right', className: 'right-align' }
			]
		},
	} )
	.then( editor => {
		window.editor = editor;
	} )
	.catch( handleSampleError );

function handleSampleError( error ) {
	const issueUrl = 'https://github.com/ckeditor/ckeditor5/issues';

	const message = [
		'Oops, something went wrong!',
		`Please, report the following error on ${ issueUrl } with the build id "ga64o4uypie7-7ocotn6jhivc" and the error stack trace:`
	].join( '\n' );

	console.error( message );
	console.error( error );
}
