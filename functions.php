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
    } //cancels function when there are no elements

    $html = ''; //begin $html string
    foreach ($elements as $elementName => $properties) {
        $html .= '<div class="element ' . $elementName . '"><p>';

        if (!isset($properties['label']) || false !== $properties['label']) {
            $html .= '<label for="' . $elementName . '">' . $properties['description'] . ':</label>';
        }

        if ($elementName == "member_id" && $properties['type'] == "select") {

            global $db;

            $html .= '<select name="' . $elementName . '" id="' . $elementName . '">
                      <option value=""></option>';

            $sql = 'SELECT members.id, members.username
                    FROM members
                    WHERE members.type="owner"
                    ORDER BY members.id ASC';
            $query = $db->prepare($sql);
            $check = $query->execute();

            if ($check === false) {
                die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
            }

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $html .= '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
            }

            $html .= '</select></p></div>' . PHP_EOL;

        } else {
            $html .= '<input type="' . $properties['type'] . '" name="' . $elementName . '" id="' . $elementName . '"></p></div>' . PHP_EOL;
        }
    }

    return $html;
}

/**
 * @param array $elements
 * @param array $requests
 *
 * @return string
 */
function getCarparkSearchQuery(array $elements, array $requests)
{
    $baseQuery = 'SELECT car_parks.id, car_parks.name, car_parks.owner, car_parks.location, car_parks.postcode, car_parks.vacancies, members.username
                  FROM car_parks
                  INNER JOIN members ON car_parks.member_id = members.id ';
    $searchTerms = array();

    foreach ($elements as $elementName => $properties) {
        if (!isset($requests[$elementName]) || (isset($properties['isSearchable']) && false === $properties['isSearchable'])) {
            continue;
        } //if a field has no name or is not defined as searchable, move onto the next field

        $field = trim($requests[$elementName]); //removes beginning and end whitespace

        if (strlen($field) === 0) {
            continue;
        } //if field is empty, move onto the next field

        if ($elementName == 'car_parks_period_id') {
            $searchTerms[] = sprintf('car_parks.id LIKE "%%%s%%"', $field);
        } else {
            $searchTerms[] = sprintf('%s LIKE "%%%s%%"', $elementName, $field); //set search term with name and field: $elementName LIKE %%$field%%
        }
    }

    if (count($searchTerms) === 0) {
        return $baseQuery;
    } //if no search terms, return basic query

    return $baseQuery . ' WHERE ' . implode(' OR ', $searchTerms); //combine all search terms into one and place next to base query
}

/**
 * @param array $elements
 * @param array $requests
 *
 * @return string
 */
function getCarparkSearchQueryGuest(array $elements, array $requests)
{
    $baseQuery = 'SELECT * FROM car_parks ';
    $searchTerms = array();

    foreach ($elements as $elementName => $properties) {
        if (!isset($requests[$elementName])
            || (isset($properties['isSearchable']) && false === $properties['isSearchable'])
        ) {
            continue;
        } //if a field has no name or is not defined as searchable, move onto the next field

        $field = trim($requests[$elementName]); //removes whitespace

        if (strlen($field) === 0) {
            continue;
        } //if field is empty, move onto the next field

        $searchTerms[] = sprintf('%s LIKE "%%%s%%"', $elementName, $field); //set search term with name and field: $elementName LIKE %%$field%%
    }

    if (count($searchTerms) === 0) {
        return $baseQuery;
    } //if no search terms, return basic query

    return $baseQuery . ' WHERE ' . implode(' OR ', $searchTerms); //combine all search terms into one and place next to base query
}

function isInteger($input){
    return(ctype_digit(strval($input)));
}