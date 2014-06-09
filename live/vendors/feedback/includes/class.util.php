<?php

/**
 * Contains misc functions
 */
class util {

    /**
     * Loads another file, returns file contents.
     * @param string $file
     * @param array $var Any variables you wish to be displayed in the template
     * @return string
     */
    static function loadTemplate($file, $var = "") {
        if (is_file($file)) {
            ob_start();
            include $file;
            $contents = ob_get_contents();
            ob_end_clean();
            return $contents;
        }
        return false;
    }

}

?>