package com.challenge.picpay.web.common.validations;

import com.challenge.picpay.web.common.exceptions.enums.common.ErrorMessageKeyTypes;
import com.challenge.picpay.web.common.exceptions.invalidaction.InvalidActionException;
import lombok.AllArgsConstructor;
import org.springframework.stereotype.Component;

@AllArgsConstructor

@Component
public class ValidatePageSizeImpl implements ValidatePageSize{
    private static final int MAX_PAGE_SIZE = 20;
    private static final int MINIMUM_PAGE_SIZE = 1;
    private static final int ZERO_PAGE_SIZE = 0;
    @Override
    public boolean getAllPageSizeValidation(int page, int size) {
        if(size > MAX_PAGE_SIZE) {
            throw new InvalidActionException(ErrorMessageKeyTypes.PAGE_SIZE_INVALID_SIZE.message);
        }
        if(size < MINIMUM_PAGE_SIZE) {
            throw new InvalidActionException(ErrorMessageKeyTypes.PAGE_SIZE_CANNOT_BE_LESS_THAN_ONE.message);
        }
        if(page < ZERO_PAGE_SIZE) {
            throw new InvalidActionException(ErrorMessageKeyTypes.PAGE_NUMBER_CANNOT_BE_LESS_THAN_ONE.message);
        }
        return false;
    }
}
