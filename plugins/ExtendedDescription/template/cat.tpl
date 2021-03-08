<ul class="thumbnailCategories">
  <li style="width: 99.5%;">
    <div class="thumbnailCategory">
      <div class="illustration">
      <a href="{$URL}">
        <img src="{$TN_SRC}" alt="{$TN_ALT}" title="{'shows images at the root of this category'|@translate}">
      </a>
      </div>
      <div class="description">
        <h3>
          <a href="{$URL}">{$NAME}</a>
        </h3>
        <div class="text" style="text-align: left;">
          {if isset($INFO_DATES) }
          <p class="dates">{$INFO_DATES}</p>
          {/if}
          <p class="Nb_images">{$CAPTION_NB_IMAGES}</p>
          {if not empty($DESCRIPTION)}
          <p>{$DESCRIPTION}</p>
          {/if}
        </div>
      </div>
    </div>
  </li>
</ul>
