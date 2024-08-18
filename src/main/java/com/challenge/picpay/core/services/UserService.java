package com.challenge.picpay.core.services;

import com.challenge.picpay.core.services.common.CommonCrudService;
import com.challenge.picpay.domain.models.entities.User;

import java.util.UUID;

public interface UserService extends CommonCrudService<User, UUID> {
}
