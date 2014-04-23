treeoflife-php
==============

### PHP Class that generates a Qabbalistic Tree of Life using HTML5 and CSS

Documentation is coming soon...

## How to use

*This documentation is still being made*

### 1st step: Including the class

Include the file tree.php in your PHP project,

    <?php
      include "tree.php";
    ?>

### 2nd step; Creating the Object

Then create an object with

    <?php
      $width = 650;
      $tree = new TreeOflife($width);
    ?>

Here, $width is the width of the Tree in pixels. If this value is supressed, it defaults to 650.

### 3rd step, outputting the tree, CSS and HTML

#### 3.1: The CSS

Inside the `<head>` of your html, you output the css, with

    <?php echo $tree->htmlandcss->css; ?>

It will inclyde the `<style>` tag

#### 3.2: The HTML elements

Then, to include the HTML elements of the tree, we can use

    echo $tree->htmlandcss->html;

