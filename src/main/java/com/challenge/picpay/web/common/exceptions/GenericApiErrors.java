package com.challenge.picpay.web.common.exceptions;

import lombok.Getter;

import java.util.Arrays;
import java.util.Collections;
import java.util.List;

@Getter
public class GenericApiErrors {
    private final List<String> errors;

    public GenericApiErrors(String message) {
        this.errors = Collections.singletonList(message);
    }

    public GenericApiErrors(List<String> errors) {
        this.errors = errors;
    }

}
