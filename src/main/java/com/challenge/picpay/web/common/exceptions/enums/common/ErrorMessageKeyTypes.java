package com.challenge.picpay.web.common.exceptions.enums.common;

public enum ErrorMessageKeyTypes {
    PAGE_SIZE_INVALID_SIZE ("Invalid page size"),
    PAGE_NUMBER_CANNOT_BE_LESS_THAN_ONE("Page number cannot be less than one"),
    PAGE_SIZE_CANNOT_BE_LESS_THAN_ONE("Page size cannot be less than one");
    public final String message;

    ErrorMessageKeyTypes(String message) {
        this.message = message;
    }

}
