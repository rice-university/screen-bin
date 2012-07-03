<?php

class Screenshot extends AppModel {
    /*
     * Adds a new notification for target user
     */
    public function addScreenshot($url_hash, $amazon_s3_url) {
        $this->create();
        $this->data['Screenshot']['url_hash'] = $url_hash;
        $this->data['Screenshot']['storage_url'] = $amazon_s3_url;
        $this->save($this->data);
    }

    /*
     * Gets the screenshot data given URL hash
     */
    public function getScreenshot($url_hash) {
        $screenshots = $this->findAllByUrlHash($url_hash);
        return $screenshots;
    }

    /*
     * Gets the total number of screenshots
     */
    public function getTotalScreenshotCount() {
        return $this->find('count');
    }
}

?>