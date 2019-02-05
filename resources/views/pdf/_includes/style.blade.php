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

		font-size: 14px;
	}

	h1, h2, h3, h4, h5, h6 {
		text-align: center;
		font-weight: bold;
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

	table {
		border-collapse: collapse;
		width: 100%;
	}

	th, td {
		padding: 4px;
		text-align: center;
	}

	tr:nth-child(even) {
		font-size: 14px;
		background-color: #f2f2f2
	}

	th {
		background-color: #3A539B;
		color: white;
	}

	.new-page {
		page-break-before: always;
	}
</style>