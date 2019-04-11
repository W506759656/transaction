<?php
return
[
    // 正确响应
    '#0' => [
        'message'     => 'OK',
        'status_code' => 200,
    ],

    // 未知异常
    '#1' => [
        'message'     => '未知异常',
        'status_code' => 500,
    ],

    // 币种id必传
    '#9001' => [
        'message'     => '币种id必传',
        'status_code' => 422,
    ],


    // 地址id必传
    '#9002' => [
        'message'     => '地址id必传',
        'status_code' => 422,
    ],

    // 交易密码错误
    '#9003' => [
        'message'     => '交易密码错误',
        'status_code' => 400,
    ],

    // 交易密码错误
    '#9004' => [
        'message'     => '钱包不存在',
        'status_code' => 400,
    ],

    // 该币种不支持提现
    '#9005' => [
        'message'     => '该币种不支持提现',
        'status_code' => 400,
    ],

    // 提现金额不能小于0
    '#9006' => [
        'message'     => '提现金额不能小于0',
        'status_code' => 400,
    ],

    // 钱包金额不足
    '#9007' => [
        'message'     => '钱包金额不足',
        'status_code' => 400,
    ],

    // 提现状态错误
    '#9008' => [
        'message'     => '提现状态错误',
        'status_code' => 400,
    ],




];