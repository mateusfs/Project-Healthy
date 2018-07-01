
<div style="width: 2600px; height: 500px;">
		<div class="divConteudo">
			<?php foreach ($produtos as $produto) { ?>
			<div style="position: relative;">
					<div class="boxgrid captionfull">
						<img src="../web/img/produto/<?= $produto->getNome()?>.jpg" />
						<div class="cover boxcaption">
							<h3><?= $produto->getDescricao(); ?></h3>
							<p><?= $produto->getDescricao(); ?></p>
						</div>
					</div>
				</div>
			<?php }?>
		</div>
</div>
<script type="text/javascript">
		$("#galeria").ImageOverlay();


			$(document).ready(function(){
				$('.boxgrid.captionfull').hover(function(){
					$(".cover", this).stop().animate({top:'100px'},{queue:false,duration:160});
				}, function() {
					$(".cover", this).stop().animate({top:'160px'},{queue:false,duration:160});
			});
		});
</script>