<style>
	@font-face {
		font-family: 'Roboto';
		src: {{ resource_path('fonts/Roboto-Regular.ttf') }} format('truetype');
		font-weight: normal;
		font-style: normal;
	}

	@font-face {
		font-family: 'Roboto';
		src: {{ resource_path('fonts/Roboto-Bold.ttf') }} format('truetype');
		font-weight: bold;
		font-style: normal;
	}

	html, body {
		font-family: "Roboto", sans-serif;
	}


	.float-left {
		float: left;
	}

	.float-right {
		float: right;
	}


	.center {
		display: block;
		margin: 0 auto;
	}

	.text-center {
		text-align: center;
	}
</style>