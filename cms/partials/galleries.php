<!-- GALERIA INSTALACION -->
<?php if (!empty($albums['videoAlbumTitle'])): ?>
    <a href="editar-album.php?album_id=<?php echo $albums['videoAlbumId']; ?>&tipo=instalacion" >
        <li>
            <div class="list-title">Editar Galería de Videos:</div>
            <div class="list-parent-title"><?php echo $albums['videoAlbumTitle']; ?></div>
        </li>
    </a>
<?php else: ?>
    <?php 
        $id = $contenido_seleccionado['id'];
        $contentTitle = $contenido_seleccionado['titulo'];
        $type = 'videos';
    ?>
    <a href="crud/create-installation-gallery.php?contentId=<?php echo "{$id}&contentTitle={$contentTitle}&type={$type}"; ?>">
        <li>
            <div class="list-parent-title">Crear Galería de Videos</div>
        </li>
    </a>
<?php endif; ?>

<?php if (!empty($albums['installationTitle'])): ?>
    <a href="editar-album.php?album_id=<?php echo $albums['installationId']; ?>&tipo=instalacion" >
        <li>
            <div class="list-title">Editar Instalación:</div>
            <div class="list-parent-title"><?php echo $albums['installationTitle']; ?></div>
        </li>
    </a>
<?php else: ?>
    <?php 
        $id = $contenido_seleccionado['id'];
        $contentTitle = $contenido_seleccionado['titulo'];
        $type = 'instalacion';
    ?>
    <a href="crud/create-installation-gallery.php?contentId=<?php echo "{$id}&contentTitle={$contentTitle}&type={$type}"; ?>">
        <li>
            <div class="list-parent-title">Crear Instalación</div>
        </li>
    </a>
<?php endif; ?>