package com.challenge.picpay.core.services.common;

import org.springframework.data.domain.Page;

public interface CommonCrudService<T, ID> {
    Page<T> getAll(int page, int size);
    T findById(ID id);
    T save(T t);
    T update(T t, ID id);
    void delete(ID id);
}
