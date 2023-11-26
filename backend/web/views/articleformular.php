<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Wlog - Coding & Learning Blog</title>

    <meta name="description"
          content="Wlog - Blog about Coding, Programming and other IT Stuff where you can learn anything about Webdevelopment, Gamedevelopment and other Topics!">
    <meta name="author" content="Wieland Wüller">

    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:image" content="<?php echo DOMAIN; ?>/web/wlog_logo.png"/>

    <?php require MAIN_PATH . '/web/template/head_styles.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/backend/web/stylesheet/main.min.css"/>
</head>

<body data-editor="ClassicEditor" data-collaboration="false" data-revision-history="false">

<?php

if (isset($success)) {

    $backgroundColorClass = "not-succeed";
    $successString = "Article update failed";

    if ($success) {
        $backgroundColorClass = "succeed";
        $successString = "Article update succeed";
    }

    ?>

    <div id="top-notification" class="top-notification <?php echo $backgroundColorClass; ?>">
        <p class="top-notification-text"><?php echo $successString; ?></p>
    </div>

    <?php
}

?>

<div class="container">
    <form method="POST" id="postForm" onsubmit="return validateForm()"
          action="<?php echo $formUrl; ?>">

        <div class="article-edit-dropdown">
            <div class="title" style="cursor: pointer" onclick="triggerDropdownMenu(event, 'article-options')"><h5>
                    Article Information</h5></div>
            <hr/>

            <div class="custom-edit-article-dropdown-content menu-open" id="article-options">
                <br/>
                <div class="input-field">
                    <input id="article_title" type="text" name="title" class="validate"
                           value="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>"/>
                    <label for="article_title" class="active">Article title</label>
                </div>

                <div class="input-field">
                    <?php
                        $creationDate = ($creationDate != '') ? date("Y-m-d", $creationDate) : "";
                    ?>

                    <input id="creation_date" type="date" name="creation_date" class="validate"
                           value="<?php echo htmlspecialchars($creationDate, ENT_QUOTES, 'UTF-8'); ?>">
                    <label for="creation_date" class="active">Creation Date</label>
                </div>

                <div class="input-field">
                    <input id="time_to_read" type="text" name="time_to_read" class="validate"
                           value="<?php echo htmlspecialchars($timeToRead, ENT_QUOTES, 'UTF-8'); ?>">
                    <label for="time_to_read" class="active">Time to read (minutes)</label>
                </div>

                <div class="input-field">
                    <input id="processed_url" type="text" name="processed_url" class="validate"
                           value="<?php echo htmlspecialchars($processedUrl, ENT_QUOTES, 'UTF-8'); ?>" readonly / >
                    <label for="processed_url" class="active">Processed url (<b>do not change!</b>)</label>
                </div>

                <div class="input-field">
                    <select multiple id="categorySelect" name="selectedCategories[]">
                        <option value="" disabled selected>Select Option</option>
                        <?php
                        foreach ($availableCategories as $key => $category) :

                            $categoryIdString = strval($category['id']);
                            $selected = (array_search($categoryIdString, $selectedCategoryIds, true) !== false) ? "selected" : "";


                            ?>
                            <option value="<?php echo $category['id']; ?>" <?php echo $selected; ?>><?php echo $category['name']; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                    <label>Select Categories</label>
                </div>

                <textarea name="content_html" class="editor" id="editor">
                <?php echo $contentHtml; ?>
            </textarea>
            </div>
        </div>

        <br/><br/><br/><br/>

        <div class="article-edit-dropdown">
            <div class="title" style="cursor: pointer" onclick="triggerDropdownMenu(event, 'seo-options')"><h5>SEO
                    Information</h5></div>
            <hr/>
            <div class="custom-edit-article-dropdown-content" id="seo-options">
                <br/>
                <div id="seoFields">
                    <div class="input-field">
                        <input id="seo_title" type="text" name="seo_title" class="validate"
                               value="<?php echo htmlspecialchars($seoTitle, ENT_QUOTES, 'UTF-8'); ?>">
                        <label for="seo_title" class="active">SEO Title</label>
                    </div>

                    <div class="input-field">
                        <input id="seo_description" type="text" name="seo_description" class="validate"
                               value="<?php echo htmlspecialchars($seoDescription, ENT_QUOTES, 'UTF-8'); ?>">
                        <label for="seo_description" class="active">SEO Description</label>
                    </div>

                    <div class="input-field">
                        <input id="seo_author" type="text" name="seo_author" class="validate"
                               value="<?php echo htmlspecialchars($seoAuthor, ENT_QUOTES, 'UTF-8'); ?>">
                        <label for="seo_author" class="active">SEO Author</label>
                    </div>

                    <div class="input-field">
                        <input id="seo_og_site_name" type="text" name="seo_og_site_name" class="validate"
                               value="<?php echo htmlspecialchars($seoOGSiteName, ENT_QUOTES, 'UTF-8'); ?>">
                        <label for="seo_og_site_name" class="active">SEO OG Sitename</label>
                    </div>

                    <div class="input-field">
                        <input id="seo_og_title" type="text" name="seo_og_title" class="validate"
                               value="<?php echo htmlspecialchars($seoOGTitle, ENT_QUOTES, 'UTF-8'); ?>">
                        <label for="seo_og_title" class="active">SEO OG Title</label>
                    </div>

                    <div class="input-field">
                        <input id="seo_og_description" type="text" name="seo_og_description" class="validate"
                               value="<?php echo htmlspecialchars($seoOGDescription, ENT_QUOTES, 'UTF-8'); ?>">
                        <label for="seo_og_description" class="active">SEO OG Description</label>
                    </div>

                    <div class="input-field">
                        <input id="seo_og_url" type="text" name="seo_og_url" class="validate"
                               value="/<?php echo htmlspecialchars($processedUrl, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        <label for="seo_og_url" class="active">SEO OG URL <b>(do not change!)</b></label>
                    </div>
                </div>
            </div>
        </div>


        <br/><br/>

        <button class="btn waves-effect waves-light" type="submit" name="action" onclick="closeDropdowns()">Submit
        </button>
    </form>
    <br/><br/>
    <br/><br/>
</div>

<script src="<?php echo DOMAIN; ?>/backend/web/javascript/ckeditor/ckeditor.js"></script>
<script src="<?php echo DOMAIN; ?>/backend/web/javascript/ckeditor/configuration.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>


    document.addEventListener('DOMContentLoaded', function () {
        const articleTitleInput = document.getElementById('article_title');
        const processedUrlInput = document.getElementById('processed_url');
        const seoOGUrlInput = document.getElementById('seo_og_url');


        if (articleTitleInput && processedUrlInput) {
            articleTitleInput.addEventListener('blur', function () {

                const articleTitle = this.value;

                let processedUrl = articleTitle.toLowerCase().replace(/[^a-z0-9]+/g, '-');
                processedUrl = processedUrl.replace(/-+$/, '');

                processedUrlInput.value = processedUrl;
                seoOGUrlInput.value = processedUrl;
            });
        }

        const selects = document.querySelectorAll('select');
        const instances = M.FormSelect.init(selects, {});
        const selectOption = document.querySelector("#categorySelect");

        selectOption.addEventListener("change", () => {
            const instance = M.FormSelect.getInstance(selectOption);
            const selectedValues = instance.getSelectedValues();
            console.log(selectedValues);
        });

    });

    function triggerDropdownMenu(e, option) {
        const element = document.getElementById(option);

        if (element !== undefined) {

            if (element.classList.contains('menu-open')) {
                element.classList.remove('menu-open');
            } else {
                element.classList.add('menu-open');
            }
        }
    }

    function validateForm() {
        const articleOptions = document.getElementById('article-options');
        const seoOptions = document.getElementById('seo-options');

        if (articleOptions.classList.contains('menu-open') || seoOptions.classList.contains('menu-open')) {

            articleOptions.classList.remove('menu-open');
            seoOptions.classList.remove('menu-open');

            return false;
        }

        return true;
    }

    function closeDropdowns() {
        const articleOptions = document.getElementById('article-options');
        const seoOptions = document.getElementById('seo-options');

        articleOptions.classList.remove('menu-open');
        seoOptions.classList.remove('menu-open');
    }

    const notificationElement = document.getElementById('top-notification');

    if (notificationElement !== null) {
        setTimeout(function () {
            notificationElement.style.display = 'none';
        }, 5000);
    }

    function handleSelectChange() {

        // Get the selected value from the select input
        /*const selectedValue = document.getElementById('categorySelect').value;

        // Create a new chip element
        const chipElement = document.createElement('div');
        chipElement.classList.add('chip');
        chipElement.textContent = selectedValue;

        // Append the chip to the container
        document.getElementById('chipContainer').appendChild(chipElement);*/
    }

</script>
</body>
</html>