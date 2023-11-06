<?php

namespace apidas\modules\v1\components\web;

class UrlManager extends \yii\web\UrlManager {

    /**
     * @param \yii\web\Request $request
     * @inheritdoc
     */
    public function parseRequest($request) {
        $route = $request->getQueryParam($this->routeParam, '');
        if ($route === '') {
            $route = $request->getBodyParams($this->routeParam, '');
        }
        if (is_array($route)) {
            $route = '';
        }
        return [(string) $route, []];
    }

}
