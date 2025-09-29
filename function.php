<?php

// ✅ Validate email format
function EmailValidation($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
