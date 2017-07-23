    <form method="<?php echo $config["options"]["method"] ?>" enctype="multipart/form-data"
      action="<?php echo $config["options"]["action"] ?>"
      class="<?php echo $config["options"]["class"] ?>"
      id="<?php echo $config["options"]["id"] ?>">
    <?php foreach ($config["struct"] as $name => $attribute): ?>
        <?php if(
            $attribute['type'] == "email" ||
            $attribute['type'] == "password" ||
            $attribute['type'] == "text" ||
            $attribute['type'] == "date"
        ): ?>
            <input type="<?php echo $attribute["type"]; ?>"
                   name="<?php echo $name; ?>"
                   placeholder="<?php echo $attribute["placeholder"]; ?>"
                   value ="<?php echo $attribute["value"]; ?>"
                   >
        <?php endif; ?>

        <!-- Champs Select -->
        <?php if(
            $attribute['type'] == "select"
        ) : ?>
            <select name="<?php echo $attribute["optionName"] ?>"><?php foreach ($config["struct"]["Option"]["option"] as $name1 => $option):?>
                    <option value="<?php echo $option;?>"><?php echo $option;?></option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <!-- Champs Checkbox -->
        <?php
        if (
            $attribute['type'] == "checkbox"
        ) :
            ?>
            <label>
                <input type="checkbox" id="<?php echo $attribute["name"] ?>" value="1" <?php if($attribute["required"] === true){echo "required";} ?> >
                <?php echo $attribute["label"] ?>
            </label>
        <?php endif; ?>

        <!-- Champs Textarea -->
        <?php if(
        $attribute['type'] == "textarea"
        ) : ?>
        <textarea class="ckeditor" name="<?php echo $name ?>" placeholder="<?php echo $attribute["placeholder"]; ?>" ><?php echo $attribute["value"]; ?></textarea>
    <?php endif; ?>

        <?php if(
        $attribute['type'] == "file"
        ): ?>
            <input type="<?php echo $attribute["type"]; ?>"
                   name="<?php echo $name; ?>"
                   placeholder="<?php echo $attribute["placeholder"]; ?>"
            >
        <?php endif; ?>

    <?php endforeach; ?>
    <input type="submit" value="Submit">
</form>