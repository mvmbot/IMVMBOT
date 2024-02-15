DELIMITER //

CREATE TRIGGER afterTicketInsert
AFTER INSERT
ON ticket

BEGIN
    INSERT INTO log (idTicket, stateBeforeLog, stateAfterLog)
    VALUES (NEW.idTicket, NULL, 'Open');
END //

DELIMITER ;