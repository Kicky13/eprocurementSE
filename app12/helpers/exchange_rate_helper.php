<?php
function exchange_rate_db()
{

    $ci =& get_instance();
    $exchange_rates = @$ci->db->select([
        'm_exchange_rate.*',
        'cur_from.currency currency_code_from',
        'cur_to.currency currency_code_to',
        ])
        ->from('m_exchange_rate')
        ->join('m_currency as cur_from', 'cur_from.id = m_exchange_rate.currency_from')
        ->join('m_currency as cur_to', 'cur_to.id = m_exchange_rate.currency_to')
        /* ->where('cur_from.currency', $from) */
        /* ->where('cur_to.currency', $to) */
        ->where("'".date('Y-m-d')."'" . ' BETWEEN valid_from AND valid_to', NULL, false)
        ->get()->result();

    $result = [];

    foreach($exchange_rates as $rate) {
        $key = sprintf('%s|%s', $rate->currency_code_from, $rate->currency_code_to);

        $result[$key] = $rate->amount_from == 0 ? 0 : $rate->amount_to / $rate->amount_from;
    }

    return $result;
    /*
    return array(
        'IDR|USD'   => 1/10000,
        'USD|IDR'   => 10000,

        'IDR|EUR'   => 1/12000,
        'EUR|IDR'   => 12000,

        'USD|EUR'   => 1/1.19,
        'EUR|USD'   => 1.19,
    );
     */
}

function find_exchange_rate_base($from, $to)
{
    /*
    $db = exchange_rate_db();

    $from = strtoupper($from);
    $to = strtoupper($to);

    if ($from == $to) {
        return 1;
    }

    $key = sprintf("%s|%s", $from, $to);

    return array_key_exists($key, $db) ? $db[$key] : 0;
     */

    $from = strtoupper($from);
    $to = strtoupper($to);

    if ($from === $to) {
        return 1;
    }

    $ci =& get_instance();
    $exchange_rate = @$ci->db->select('m_exchange_rate.*')
        ->from('m_exchange_rate')
        ->join('m_currency as cur_from', 'cur_from.id = m_exchange_rate.currency_from')
        ->join('m_currency as cur_to', 'cur_to.id = m_exchange_rate.currency_to')
        ->where('cur_from.currency', $from)
        ->where('cur_to.currency', $to)
        ->where("'".date('Y-m-d')."'" . ' BETWEEN valid_from AND valid_to', NULL, false)
        ->get()->row();

    if (!$exchange_rate) {
        return 0;
    }

    $amount_from = (float) $exchange_rate->amount_from;
    $amount_to = (float) $exchange_rate->amount_to;

    // will cause error Division by zero
    if ($amount_from == 0) {
        return 0;
    }

    return $amount_to / $amount_from;
}

function find_exchange_rate_base_by_currency_id($from_id, $to_id)
{
    if ($from_id === $to_id) {
        return 1;
    }

    $ci =& get_instance();
    $exchange_rate = @$ci->db->select('m_exchange_rate.*')
        ->from('m_exchange_rate')
        ->where('currency_from', $from_id)
        ->where('currency_to', $to_id)
        ->where("'".date('Y-m-d')."'" . ' BETWEEN valid_from AND valid_to', NULL, false)
        ->get()->row();

    if (!$exchange_rate) {
        return 0;
    }

    $amount_from = (float) $exchange_rate->amount_from;
    $amount_to = (float) $exchange_rate->amount_to;

    // will cause error Division by zero
    if ($amount_from == 0) {
        return 0;
    }

    return $amount_to / $amount_from;
}

function get_exchange_rate_by_currency_id($from_id, $to_id)
{
    $ci =& get_instance();
    return @$ci->db->select('m_exchange_rate.*')
        ->from('m_exchange_rate')
        ->where('currency_from', $from_id)
        ->where('currency_to', $to_id)
        ->where("'".date('Y-m-d')."'" . ' BETWEEN valid_from AND valid_to', NULL, false)
        ->get()->row();
}

function get_exchange_rate($from, $to)
{
    $ci =& get_instance();
    return @$ci->db->select('m_exchange_rate.*')
        ->from('m_exchange_rate')
        ->where('currency_from', $from_id)
        ->where('currency_to', $to_id)
        ->where("'".date('Y-m-d')."'" . ' BETWEEN valid_from AND valid_to', NULL, false)
        ->get()->row();
}

function exchange_rate($from, $to, $amount)
{
    $rate = find_exchange_rate_base($from, $to);
    return $amount * $rate;
}

function exchange_rate_by_id($from_id, $to_id, $amount)
{
    $ci =& get_instance();
    $ci->load->model('other_master/M_currency');

    $from = @$ci->M_currency->find($from_id)->CURRENCY;
    $to = @$ci->M_currency->find($to_id)->CURRENCY;

    return exchange_rate($from, $to, $amount);
}

function base_currency()
{
    // TODO: move to config or db
    // return 3; // USD

    return @get_base_currency()->ID;
}

function base_currency_code()
{
    return @get_base_currency()->CURRENCY;
}

/**
 * Get base currency in currency "object" at once
 */
function get_base_currency()
{
    $ci =& get_instance();
    $ci->load->model('other_master/M_currency');

    return @$ci->M_currency->getBaseCurrency();
}

function display_money($amount, $currency)
{
    // Note:
    // - display in format <currency> <amount>. eg: USD 1000; (TODO: configurable)
    // - $amount should be already preformated

    $text = '';

    if ($currency) {
        $text .= $currency . ' ';
    }

    return $text . $amount;
}

function display_multi_currency_format($amount_from, $currency_from, $amount_to, $currency_to)
{
    $CI = get_instance();
    $CI->load->helper('global');
    $text = display_money(numIndo($amount_from), $currency_from);

    if ($currency_from != $currency_to) {
        $text .= ' <br><small>(equal to ' . display_money(numIndo($amount_to), $currency_to) . ')</small>';
    }

    return $text;
}


//Sama seperti display_multi_currency_format namun deskripsi equal berada di bawah
function display_multi_line_currency_format($amount_from, $currency_from, $amount_to, $currency_to)
{
    $text = display_money($amount_from, $currency_from);

    if ($currency_from != $currency_to) {
        $text .= '<br><small class="text-muted">(equal to ' . display_money($amount_to, $currency_to) . ')</small>';
    }

    return $text;
}
