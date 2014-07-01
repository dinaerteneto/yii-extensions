<div class="no-conflict-extension-upload" id="upload-container">
    <span class="bg-message-bottom"></span>
    <span class="message-bottom" style="display: none">
        você pode arrastar mais fotos para cá ou 
        <span onclick="javascript: $('input#file').click();" class="span-button">selecione fotos do computador</span>
    </span>
    <input class="lobster hide" type="file" name="file" id="file" multiple />
    <div style="overflow: auto;">
        <div id="dropbox">
            <span class="message">
                <figure><img src="<?php echo $assets;?>/img/camera_icon.png" /></figure>
                <span>arraste as fotos para cá</span>
                <img class="hr-ou" src="<?php echo $assets;?>/img/hr-ou.png" alt="ou" />
                <span onclick="javascript: $('input#file').click();" class="span-button">selecione fotos do computador</span>
            </span>
        </div>
    </div>
</div>