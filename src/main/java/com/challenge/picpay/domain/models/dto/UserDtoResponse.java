package com.challenge.picpay.domain.models.dto;

import java.util.UUID;

public record UserDtoResponse(UUID id, String name, String code, String email) {
}
