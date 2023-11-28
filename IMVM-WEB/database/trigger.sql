DELIMITER //

CREATE TRIGGER after_ticket_insert
AFTER INSERT
ON ticket

BEGIN
    INSERT INTO log (id_ticket, stateBefore_log, stateAfter_log)
    VALUES (NEW.id_ticket, NULL, 'Open');
END //

DELIMITER ;