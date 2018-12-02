<?php

/*
 * This file is part of the ActivityPub package.
 *
 * Copyright (c) landrok at github.com/landrok
 *
 * For the full copyright and license information, please see
 * <https://github.com/landrok/activitypub/blob/master/LICENSE>.
 */

namespace ActivityPub\Type\Validator;

use ActivityPub\Type\Util;
use ActivityPub\Type\Validator;
use ActivityPub\Type\ValidatorInterface;
use stdClass;

/**
 * \ActivityPub\Type\Validator\ContentValidator is a dedicated
 * validator for content attribute.
 */
class ContentMapValidator implements ValidatorInterface
{
    /**
     * Validate a contentMap attribute value
     * 
     * @param string  $value
     * @param mixed   $container A Question type
     * @return bool
     */
    public function validate($value, $container)
    {
        // Can be a JSON string
        if (is_string($value)) {
            $value = Util::decodeJson($value);
        }

        // A map
        if (is_object($value)) {
            return $this->validateObject($value, $container);
        }
    }

    /**
     * Validate a list of key=>value strings
     * 
     * @param  object $map
     * @return bool
     */
    protected function validateObject(stdClass $map, $container)
    {
        foreach ($map as $key => $value) {
            if (!is_string($key) 
                || !Validator::validate('content', $value, $container)
            ) {
                return false;
            }
        }

        return true;
    }
}
