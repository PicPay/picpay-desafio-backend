package com.challenge.picpay.web.common.exceptions.invalidcode;

public class InvalidCodeException extends RuntimeException {
    public InvalidCodeException(String message) {
        super(message);
    }
}
