select * from (
    select c.codigo_completo,
           c.nome,
           ifnull((select sum(valor) from lancamentos l where l.conta_debito_id = c.id and l.deleted_at is null), 0) - ifnull((select sum(valor) from lancamentos l where l.conta_credito_id = c.id and l.deleted_at is null), 0) saldo_calculado,
           c.saldo
      from contas c
     where c.codigo_completo like '%'
       and c.deleted_at is null
) a
where a.saldo_calculado <> a.saldo
  and a.saldo_calculado <> -a.saldo;