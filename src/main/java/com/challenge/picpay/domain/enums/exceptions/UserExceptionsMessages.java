package com.challenge.picpay.domain.enums.exceptions;

public enum UserExceptionsMessages {
    NOT_FOUND ("User with provided id cannot be found");

    public final String message;

    UserExceptionsMessages(String message) {
        this.message = message;
    }
}
