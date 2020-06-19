<!DOCTYPE html>
					<html lang="es" dir="ltr">
					  <head>
						<meta charset="utf-8">
					  </head>
					  <style>
							figure{
								display: flex;
								justify-content: center;
								align-items: center;
								max-height: 200px;
								max-width: 200px;
							}
							figure img{
								height: auto;
								width: auto;
								max-width: 200px;
								max-height: 200px;
							}
							h1{font-size: 5vh;color: black;line-height: 7vh;text-shadow: 0 2px 2px rgba(0, 0, 0, 0.32);font-family: 'Roboto Condensed', sans-serif;}
					  </style>
					  <body>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td style="text-align: center;">
									<h1 style="text-align: center;">Escuela Secundaria Nro 2 Rawson</h1>
									<h3 style="text-align: center;">Verificar el email</h3>
									<h4>Para completar el registro haz <a href="{{$actionUrl}}">Click Aqui</a></h4>
									<h4>Gracias</h4>
                  <p style="text-align: center;">Si su navegador no le permite hacer Click, por favor copia y pega el siguiente link en la barra de busqueda:</p>
                  <spam>{{$actionUrl}}</spam>
								</td>
							</tr>
						</table>
					  </body>
					</html>
