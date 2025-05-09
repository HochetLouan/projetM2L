<div class="conteneur">
	<head>
		<link rel="stylesheet" href="../../styles/styleFormation.css">
	</head>
	<main>
		<?php 
			if(isset($formDemandes)){
				$formDemandes->afficherFormulaire();
			}
		?>
	</main>
</div>