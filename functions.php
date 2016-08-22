<?php

/**
 * Sanitise (sort of) user input
 *
 * @param string $data
 *
 * @return string
 */
function input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * @param array $elements
 *
 * @return string
 */
function generateElements(array $elements)
{
    if (count($elements) === 0) {
        return '';
    }

    $html = '';
    foreach ($elements as $elementName => $properties) {
        $html .= '
        <div class="element ' . $elementName . '">
        ';

        if (!isset($properties['label']) || false !== $properties['label']) {
            $html .= '<label for="' . $elementName . '">' . $properties['description'] . ':</label>';
        }

        $html .= '
            <input type="' . $properties['type'] . '" name="' . $elementName . '" id="' . $elementName . '">
        </div>
        ' . PHP_EOL;
    }

    return $html;
}

/**
 * @param array $elements
 * @param array $requests
 * @param mysqli $db
 *
 * @return string
 */
function getCarparkSearchQuery(array $elements, array $requests)
{
    $baseQuery = 'SELECT * FROM car_parks ';
    $searchTerms = array();

    foreach ($elements as $elementName => $properties) {
        if (!isset($requests[$elementName])
            || (isset($properties['isSearchable']) && false === $properties['isSearchable'])
        ) {
            continue;
        }

        $field = trim($requests[$elementName]);

        if (strlen($field) === 0) {
            continue;
        }

        $searchTerms[] = sprintf('%s LIKE "%%%s%%"', $elementName, $field);
    }

    if (count($searchTerms) === 0) {
        return $baseQuery;
    }

    return $baseQuery . ' WHERE ' . implode(' OR ', $searchTerms);
}